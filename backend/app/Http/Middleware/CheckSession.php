<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckSession
{
    public function handle(Request $request, Closure $next)
    {
        if (isset($_SESSION['user'])) {
            header('Location: /api/customers');
            exit();
        }

        return $next($request);
    }
}
