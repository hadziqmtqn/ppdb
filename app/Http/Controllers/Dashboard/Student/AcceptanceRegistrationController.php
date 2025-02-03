<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\AcceptanceRegistrationRequest;
use App\Models\User;
use App\Repositories\SendMessage\AcceptanceRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AcceptanceRegistrationController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected AcceptanceRegistrationRepository $acceptanceRegistrationRepository;

    public function __construct(AcceptanceRegistrationRepository $acceptanceRegistrationRepository)
    {
        $this->acceptanceRegistrationRepository = $acceptanceRegistrationRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware('role:super-admin|admin')
        ];
    }

    public function store(AcceptanceRegistrationRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->load('student.educationalInstitution');
            $student = $user->student;

            if ($student->registration_validation != 'valid') return $this->apiResponse('Data registrasi tidak valid', null, null, Response::HTTP_BAD_REQUEST);

            $student->registration_status = $request->input('registration_status');
            $student->save();
            $student->refresh();

            // TODO Send Message
            $this->acceptanceRegistrationRepository->sendMessage([
                'username' => $user->name,
                'educationalInstitution' => optional($student->educationalInstitution)->name,
                'website' => optional($student->educationalInstitution)->website,
                'educationalInstitutionId' => $student->educational_institution_id,
                'registrationStatus' => $student->registration_status,
                'email' => $user->email,
                'phone' => $student->whatsapp_number
            ]);
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $student->registration_status, route('student.show', $user->username), Response::HTTP_OK);
    }
}
