<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\SecurityRequest;
use App\Models\User;
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
            $user->email = $request->input('email');
            $user->password = $request->input('password') ? Hash::make($request->input('password')) : $user->password;
            $user->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $user, route('student-security.index', $user->username), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
