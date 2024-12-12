<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuthUserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $isCurrentUser = isset($_SESSION['user']);

        $currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($isCurrentUser && $currentUrl === '/api/login') {
            header('Location: /api/customers');
            exit();
        } else {
            return $next($request);
        }

        if (!$isCurrentUser) {
            return json_response(null, 401, false, 'Unauthorized');
        }

        return $next($request);
    }
}
