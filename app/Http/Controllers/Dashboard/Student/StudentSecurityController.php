<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\SecurityRequest;
use App\Models\User;
use App\Repositories\SendMessage\SafetyChangesRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentSecurityController extends Controller
{
    use ApiResponse;

    protected SafetyChangesRepository $safetyChangesRepository;

    public function __construct(SafetyChangesRepository $safetyChangesRepository)
    {
        $this->safetyChangesRepository = $safetyChangesRepository;
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Siswa';

        return \view('dashboard.student.security.index', compact('title', $user));
    }

    public function store(SecurityRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->load('student');

            $user->email = $request->input('email');
            $user->password = $request->input('password') ? Hash::make($request->input('password')) : $user->password;
            $user->save();

            // TODO Send Message
            $this->safetyChangesRepository->sendMessage([
                'username' => $user->name,
                'password' => $request->input('password') ?? '_Tidak ada perubahan_',
                'newEmail' => $request->input('email') != $user->email ? $request->input('email') : '_Tidak ada perubahan_',
                'oldEmail' => $user->email,
                'whatsappNumber' => optional($user->student)->whatsapp_number
            ]);
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $user, route('student-security.index', $user->username), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
