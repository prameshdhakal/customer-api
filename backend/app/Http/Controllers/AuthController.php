<?php

namespace App\Http\Controllers;

use App\Http\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController
{
    public function login(Request $request)
    {
        $email    = $request['email'] ?? 'johndoe1@example.com';
        $password = $request['password'] ?? 'password';

        $customer = Customer::where('email', $email)->first();

        if ($customer && password_verify($password, $customer['password'])) {
            unset($customer['password']);

            $_SESSION['user'] = $customer;

            $data = [
                'token' => generate_token($_SESSION['user']),
                'user'  => $customer
            ];

            return json_response($data, 200, true, 'Login successfully.');
        } else {
            return json_response(null, 401, false, 'Login credential failed.');
        }
    }

    public function logout()
    {
        session_unset();

        return json_response(null, 200, true, 'Logout successfully.');
    }
}
