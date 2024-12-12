<?php

namespace App\Traits;

use App\Http\Models\Customer;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Http\Request;

trait QueryTrait
{
    public function getLatestAddressOfCustomer()
    {
        return Customer::with('latestAddress')->get();
    }
    public function getCustomerWithNearPersonAddress(array $data)
    {
        $latitude          = $data['latitude'] ?? '';
        $longitude         = $data['longitude'] ?? '';
        $excludeCustomerId = $_SESSION['user']['id'] ?? 1;

        $latestAddresses = Capsule::table('addresses as a')
            ->join(
                Capsule::raw('(SELECT customer_id, MAX(id) AS latest_id FROM addresses GROUP BY customer_id) as latest'),
                'a.id',
                '=',
                'latest.latest_id'
            )
            ->select(
                'a.customer_id',
                'a.geolat',
                'a.geolng',
                'a.city',
                'a.state',
                'a.zipcode'
            );

        $searchQuery = Capsule::table('customers as c')
            ->joinSub($latestAddresses, 'la', 'c.id', '=', 'la.customer_id')
            ->select(
                'c.*',
                Capsule::raw('NULL AS password'),
                'la.city',
                'la.state',
                'la.zipcode',
                'la.geolat',
                'la.geolng',
                Capsule::raw(
                    "CONCAT(
                ROUND(
                    (6371 * ACOS(
                        COS(RADIANS(?)) * COS(RADIANS(la.geolat)) * COS(RADIANS(la.geolng) - RADIANS(?)) + 
                        SIN(RADIANS(?)) * SIN(RADIANS(la.geolat))
                    )), 3
                ),
                ' km'
            ) AS distance"
                ),
                Capsule::raw(
                    "CONCAT(la.city, ', ', la.state, ' ', la.zipcode) AS full_address"
                )
            )
            ->addBinding($latitude, 'select')
            ->addBinding($longitude, 'select')
            ->addBinding($latitude, 'select');

        // Add filtering for geolat, geolng, name, and email
        if (!empty($geolat) && !empty($geolng)) {
            $searchQuery->whereRaw('ROUND(la.geolat, 5) = ROUND(?, 5)', [$geolat])
                ->whereRaw('ROUND(la.geolng, 5) = ROUND(?, 5)', [$geolng]);
        }

        // Add ordering by customer ID and distance
        $searchQuery->orderByRaw(
            "CASE WHEN c.id = ? THEN 0 ELSE 1 END, distance ASC",
            [$excludeCustomerId]
        );

        $searchQuery->orderByRaw(
            "CASE WHEN c.id = ? THEN 0 ELSE 1 END, distance ASC",
            [$excludeCustomerId]
        );

        $customersWithDistance = $searchQuery->get();

        return $customersWithDistance;
    }
}
