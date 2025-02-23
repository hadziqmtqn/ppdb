<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserDashboardMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->hasRole('user')) return $next($request);

        return to_route('dashboard');
    }
}
