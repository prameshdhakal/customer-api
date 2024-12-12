<?php

namespace App\Providers;

use App\Http\Middleware\HandleCors;
use Dotenv\Dotenv;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Routing\CallableDispatcher;
use Illuminate\Http\Request;
use Spatie\Ignition\Ignition;

class AppServiceProvider
{
    protected $container;
    protected $router;
    protected $dispatcher;

    public function __construct()
    {
        $this->container  = new Container;
        $this->dispatcher = new Dispatcher($this->container);
        $this->router     = new Router($this->dispatcher, $this->container);
    }

    public function register()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->container->bind(\Illuminate\Routing\Contracts\CallableDispatcher::class, function ($container) {
            return new CallableDispatcher($container);
        });

        $this->container->alias(\App\Http\Middleware\CheckAuthUserMiddleware::class, 'auth');
        $this->container->alias(\App\Http\Middleware\ForceJsonResponse::class, 'api');

        $this->setupDatabase();
    }

    public function boot()
    {
        Ignition::make()->register();
        HandleCors::handle();

        $this->router->fallback(function () {
            return json_response(null, 404, false, 'Page Not Found.');
        });

        session_start();

        $this->router->group([
            'prefix' => 'api',
            'middleware' => ['api']
        ], function () {
            require __DIR__ . '/../../routes/api.php';
        });
    }

    protected function setupDatabase()
    {
        $config = require __DIR__ . '/../../config/database.php';

        $capsule = new Capsule;
        $capsule->addConnection($config);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function handleRequest()
    {
        $request  = Request::capture();
        $response = $this->router->dispatch($request);
        $response->send();
    }
}
