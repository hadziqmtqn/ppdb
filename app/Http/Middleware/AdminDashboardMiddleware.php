<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminDashboardMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->hasRole('user')) return to_route('user-dashboard.index');

        return $next($request);
    }
}
