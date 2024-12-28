<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Log;

class LogoutController extends Controller
{
    public function logout()
    {
        try {
            auth()->logout();
            return to_route('login')->with('success', 'Berhasil logout.');
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat logout.');
        }
    }
}
