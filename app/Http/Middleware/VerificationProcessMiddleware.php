<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificationProcessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->email_verified_at) return $next($request);

        return to_route('dashboard');
    }
}
