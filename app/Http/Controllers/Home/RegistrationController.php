<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\RegisterRequest;
use App\Models\Student;
use App\Models\User;
use App\Repositories\ApplicationRepository;
use App\Repositories\EducationalInstitutionRepository;
use App\Repositories\SaveNewAccountRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\SendMessage\AccountVerificationRepository;
use App\Repositories\SendMessage\RegistrationMessageRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    use ApiResponse;

    protected EducationalInstitutionRepository $educationalInstitutionRepository;
    protected RegistrationMessageRepository $registrationMessageRepository;
    protected SchoolYearRepository $schoolYearRepository;
    protected ApplicationRepository $applicationRepository;
    protected AccountVerificationRepository $accountVerificationRepository;
    protected SaveNewAccountRepository $saveNewAccountRepository;

    public function __construct(EducationalInstitutionRepository $educationalInstitutionRepository, RegistrationMessageRepository $registrationMessageRepository, SchoolYearRepository $schoolYearRepository, ApplicationRepository $applicationRepository, AccountVerificationRepository $accountVerificationRepository, SaveNewAccountRepository $saveNewAccountRepository)
    {
        $this->educationalInstitutionRepository = $educationalInstitutionRepository;
        $this->registrationMessageRepository = $registrationMessageRepository;
        $this->schoolYearRepository = $schoolYearRepository;
        $this->applicationRepository = $applicationRepository;
        $this->accountVerificationRepository = $accountVerificationRepository;
        $this->saveNewAccountRepository = $saveNewAccountRepository;
    }

    public function index(): View
    {
        $title = 'Registrasi';
        $educationalInstitutions = $this->educationalInstitutionRepository->getEducationalInstitutionWithSchedule();

        return \view('home.register.index', compact('title', 'educationalInstitutions'));
    }

    public function store(RegisterRequest $request): JsonResponse
    {
        $schoolYearActive = $this->schoolYearRepository->getSchoolYearActive();
        $application = $this->applicationRepository->getApplication();

        try {
            DB::beginTransaction();
            // TODO create user
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $password = $request->input('password');
            $user->password = Hash::make($password);
            $user->email_verified_at = !$application['registerVerification'] ? now() : null;
            $user->save();
            $user->refresh();

            // TODO assign user role
            $user->assignRole('user');

            // TODO create student
            $student = new Student();
            $student->user_id = $user->id;
            $student->school_year_id = $schoolYearActive['id'];
            $student->educational_institution_id = $request->input('educational_institution_id');
            $student->registration_category_id = $request->input('registration_category_id');
            $student->class_level_id = $request->input('class_level_id');
            $student->registration_path_id = $request->input('registration_path_id');
            $student->major_id = $request->input('major_id');
            $student->nisn = $request->input('nisn');
            $student->whatsapp_number = $request->input('whatsapp_number');
            $student->save();
            $student->refresh();

            // TODO Send Message
            $this->registrationMessageRepository->sendMessage([
                'educationalInstitutionId' => $student->educational_institution_id,
                'educationalInstitution' => optional($student->educationalInstitution)->name,
                'name' => $user->name,
                'email' => $user->email,
                'whatsappNumber' => $student->whatsapp_number,
                'password' => $password,
                'registrationPath' => optional($student->registrationPath)->name,
                'major' => optional($student->major)->name
            ]);

            // TODO Send Account Verification
            if ($application['registerVerification']) {
                $saveNewAccount = $this->saveNewAccountRepository->save([
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);

                $this->accountVerificationRepository->sendMessage($saveNewAccount['email'], route('account-verification.verification', ['token' => $saveNewAccount['token']]), $student->whatsapp_number);
            }

            // TODO Login
            Auth::login($user);
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, route('dashboard'), Response::HTTP_OK);
    }
}
