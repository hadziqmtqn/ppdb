<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        $title = 'Login';

        return view('home.auth.login', compact('title'));
    }

    public function store(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');

            if (auth()->attempt($credentials)) {
                if (!auth()->user()->is_active) {
                    auth()->logout();

                    return to_route('login')->with('error', 'Akun Anda tidak aktif');
                }

                return to_route('dashboard')
                    ->with('success', 'Selamat datang ' . auth()->user()->name);
            }
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Gagal masuk');
        }
    }
}
