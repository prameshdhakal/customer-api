<?php

namespace App\Traits;

trait ValidationTrait
{
    public function customerStoreRule()
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'city'     => 'required|string|max:255',
            'state'    => 'required|string|max:255',
            'zipcode'  => 'required|integer|max:20',
            'geolat'   => 'required',
            'geolng'   => 'required'
        ];
    }

    public function customerUpdateRule()
    {
        return [
            'name'     => 'required|string|max:255',
            // 'email'    => 'required|email|unique:users,email',
            'password' => 'nullabel|required|min:8',
            'city'     => 'required|string|max:255',
            'state'    => 'required|string|max:255',
            'zipcode'  => 'required|integer|max:20',
            'geolat'   => 'required',
            'geolng'   => 'required'
        ];
    }
}
