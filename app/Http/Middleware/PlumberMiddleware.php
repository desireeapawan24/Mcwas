<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlumberMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isPlumber()) {
            abort(403, 'Unauthorized access. Plumber privileges required.');
        }

        return $next($request);
    }
}




