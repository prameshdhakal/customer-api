<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['full_address'];

    public function getFullAddressAttribute()
    {
        return join(', ', [$this->city, $this->state, $this->zipcode]);
    }
}
