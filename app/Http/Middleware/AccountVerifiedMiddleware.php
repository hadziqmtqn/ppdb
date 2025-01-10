<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccountVerifiedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // jika email sudah diverifikasi lanjutkan proses berikutnya
        if (auth()->user()->email_verified_at) return $next($request);

        // jika email belum diverifikasi kembalikan ke laman verifikasi
        return to_route('account-verification.index');
    }
}
