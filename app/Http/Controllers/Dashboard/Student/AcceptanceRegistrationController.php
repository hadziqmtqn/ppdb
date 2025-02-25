<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\AcceptanceRegistrationRequest;
use App\Models\User;
use App\Repositories\RegistrationFeeRepository;
use App\Repositories\SendMessage\AcceptanceRegistrationRepository;
use App\Repositories\Student\Payment\PaymentTransactionRepository;
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
    protected RegistrationFeeRepository $registrationFeeRepository;
    protected PaymentTransactionRepository $paymentTransactionRepository;

    public function __construct(AcceptanceRegistrationRepository $acceptanceRegistrationRepository, RegistrationFeeRepository $registrationFeeRepository, PaymentTransactionRepository $paymentTransactionRepository)
    {
        $this->acceptanceRegistrationRepository = $acceptanceRegistrationRepository;
        $this->registrationFeeRepository = $registrationFeeRepository;
        $this->paymentTransactionRepository = $paymentTransactionRepository;
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
            $user->load('student');
            $student = $user->student;

            $registrationFeeActive = $this->registrationFeeRepository->getActiveRegistrationFee($user);
            $paymentRegistrationTransactionExists = $this->paymentTransactionRepository->getPaymentRegistrationExists($user);

            // Check if registration validation is valid
            if ($student->registration_validation != 'valid') return $this->apiResponse('Data registrasi tidak valid', null, null, Response::HTTP_BAD_REQUEST);

            // 1. Check if educational institution has registration fee by registration status "siswa_belum_diterima" and school year id is same with student school year id and is active
            // 2. Check if payment transaction exists
            if ($registrationFeeActive && !$paymentRegistrationTransactionExists) {
                return $this->apiResponse('Siswa belum membayar biaya registrasi!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
            }

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
