<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;

$this->router->post('/login', [AuthController::class, 'login']);
$this->router->post('/logout', [AuthController::class, 'logout']);

// authenticate routes
$this->router->group([
    'prefix' => 'customers',
    'middleware' => ['auth']
], function () {

    // customers api routes
    $this->router->get('/', [CustomerController::class, 'index'])->name('customer.list');
    $this->router->post('/', [CustomerController::class, 'store']);
    $this->router->put('/{id}', [CustomerController::class, 'update']);
    $this->router->delete('/{id}', [CustomerController::class, 'destroy']);
});
