<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Repositories\Student\StudentRegistrationRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class LoginController extends Controller
{
    protected StudentRegistrationRepository $studentRegistrationRepository;

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
    }

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

                // jika user/siswa dan belum selesai tahap registrasi, alihkan ke halaman registrasi
                if (auth()->user()->hasRole('user')) {
                    $user = User::find(auth()->id());
                    $allCompleted = $this->studentRegistrationRepository->allCompleted($user);

                    if (!$allCompleted) {
                        return redirect()->route('student-registration.index', auth()->user()->username)
                            ->with('warning', 'Harap lengkapi data pendaftaran');
                    }
                }

                // alihkan ke halaman dashboard
                return redirect()->intended(route('dashboard'))
                    ->with('success', 'Selamat datang ' . auth()->user()->name);
            }
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Gagal masuk');
        }

        return to_route('login')->with('error', 'Cek kembali akun Anda');
    }
}
