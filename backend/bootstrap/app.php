<?php

require '../vendor/autoload.php';

use App\Providers\AppServiceProvider;

// Initialize AppServiceProvider
$appServiceProvider = new AppServiceProvider();

// Register services
$appServiceProvider->register();

// Boot services (load routes, etc.)
$appServiceProvider->boot();

// Handle the HTTP request
$appServiceProvider->handleRequest();
