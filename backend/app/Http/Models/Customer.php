<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = ['id'];

    public function addresses()
    {
        return $this->hasMany(Address::class, 'customer_id', 'id');
    }

    public function latestAddress()
    {
        return $this->hasOne(Address::class)->latestOfMany();
    }
}
