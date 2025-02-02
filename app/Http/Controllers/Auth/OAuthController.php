<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\ApplicationRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    protected ApplicationRepository $applicationRepository;

    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleCallback($provider)
    {
        try {
            $socialite = Socialite::driver($provider)->user();

            $user = User::query()
                ->where('email', $socialite->getEmail())
                ->first();

            DB::beginTransaction();

            if ($user) {
                if (!$user->is_active) {
                    return to_route('login')->with('error', 'Akun Anda tidak aktif');
                }

                Auth::login($user);
            } else {
                return to_route('login')->with('error', 'Akun tidak terdaftar');
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return to_route('login')->with('error', 'Gagal login aplikasi');
        }

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Selamat datang ' . Auth::user()->name);
    }
}
