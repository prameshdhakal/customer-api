<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->is('api/*')) {
            if (!$response instanceof Response) {
                return Response::make($response->getOriginalContent(), 200);
            }
        }

        return $next($request);
    }
}
