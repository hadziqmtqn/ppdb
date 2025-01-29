<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $student = User::whereHas('student')
            ->where('username', $request->route('user')->username)
            ->first();

        if (!$student) abort(403, 'Ini bukan data siswa');

        return $next($request);
    }
}
