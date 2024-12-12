<?php

namespace App\Http\Controllers;

use App\Http\Models\Address;
use App\Http\Models\Customer;
use App\Service\Validator;
use App\Traits\QueryTrait;
use App\Traits\ValidationTrait;

class CustomerController extends BaseController
{
    use QueryTrait, ValidationTrait;

    public function index()
    {
        $request = $this->getJsonInput(['geolat', 'geolng']);

        $data = [
            'latitude'  => $request['geolat'] ?? '',
            'longitude' => $request['geolng'] ?? ''
        ];

        $customersWithDistance = $this->getCustomerWithNearPersonAddress($data);

        return json_response($customersWithDistance, 200, true, 'Customer fetched successfully.');
    }

    public function store()
    {
        $request = $this->getJsonInput(['name', 'email', 'password', 'city', 'state', 'zipcode', 'geolat', 'geolng']);

        $validator = new Validator($request);
        $validator->setRules($this->customerStoreRule());

        if (!$validator->validate()) {
            $errors = $validator->errors();
            return json_response($errors, 422, true, 'Validation failed.');
        }

        $hashPassword = password_hash($request['password'], PASSWORD_DEFAULT);

        $customerData = [
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => $hashPassword
        ];
        // creates customers table record
        $customer = Customer::create($customerData);

        $customerAddressData = [
            'customer_id' => $customer->id,
            'city'        => $request['city'],
            'state'       => $request['state'],
            'zipcode'     => $request['zipcode'],
            'geolat'      => $request['geolat'],
            'geolng'      => $request['geolng'],
        ];
        // created address table record with customer_id
        Address::create($customerAddressData);

        return json_response(null, 201, true, 'Customer created successfully.');
    }

    public function update($id)
    {
        $request = $this->getJsonInput(['name', 'email', 'password', 'city', 'state', 'zipcode', 'geolat', 'geolng']);

        $validator = new Validator($request);
        $validator->setRules($this->customerUpdateRule());

        $customer = Customer::find($id);
        if (!$customer) {
            return json_response(null, 404, true, 'No record found.');
        }

        $customerData = [
            'name'     => $request['name'],
            // 'email'    => $request['email'],
        ];

        if (isset($request['password'])) {
            $hashPassword = password_hash($request['password'], PASSWORD_DEFAULT);
            $customerData['password'] = $hashPassword;
        }

        $customer->update($customerData);

        if ($customer) {
            $address = Address::where('customer_id', $id)->first();

            $customerAddressData = [
                'customer_id' => $customer->id, // adds customer id
                'city'        => $request['city'],
                'state'       => $request['state'],
                'zipcode'     => $request['zipcode'],
                'geolat'      => $request['geolat'],
                'geolng'      => $request['geolng'],
            ];

            $address->update($customerAddressData);
        }

        return json_response(null, 200, true, 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        Customer::find($id)->delete();
        return json_response(null, 204, true, 'Customer deleted successfully.');
    }
}
