<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OnlyAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->hasRole('user')) return to_route('student.show', auth()->user()->username);

        return $next($request);
    }
}
