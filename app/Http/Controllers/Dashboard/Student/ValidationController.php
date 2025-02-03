<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ValidationRequest;
use App\Models\User;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ValidationController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected StudentRegistrationRepository $studentRegistrationRepository;

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware('role:super-admin|admin')
        ];
    }

    public function store(ValidationRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $allCompetencies = $this->studentRegistrationRepository->allCompleted($user);

            if (!$allCompetencies) {
                return $this->apiResponse('Data Registrasi belum lengkap!!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $user->load('student');
            $student = $user->student;

            $student->registration_validation = $request->input('registration_validation');
            $student->registration_status = $student->registration_status == 'diterima' ? $student->registration_status : 'belum_diterima';
            $student->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, route('student.show', $user->username), Response::HTTP_OK);
    }
}
