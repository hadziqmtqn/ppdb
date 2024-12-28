<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\ApplicationRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $application = $this->applicationRepository->getApplication();

        try {
            $user = Socialite::driver($provider)->user();

            $finduser = User::query()
                ->where('email', $user->getEmail())
                ->first();

            DB::beginTransaction();

            if ($finduser) {
                if (!$finduser->is_active) {
                    return to_route('login')->with('error', 'Akun Anda tidak aktif');
                }

                Auth::login($finduser);
            } else {
                $newUser = new User();
                $newUser->name = $user->getName();
                $newUser->email = $user->getEmail();
                $newUser->oauth_id = $user->getId();
                $newUser->oauth_type = $provider;
                $newUser->password = Hash::make('Pas$w0Rdd1122');
                $newUser->account_verified = !$application['registerVerification'];
                $newUser->save();

                $newUser->assignRole('user');

                Auth::login($newUser);
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return to_route('login')->with('error', 'Gagal login aplikasi');
        }

        return to_route('dashboard')
            ->with('success', 'Selamat datang ' . Auth::user()->name);
    }
}
