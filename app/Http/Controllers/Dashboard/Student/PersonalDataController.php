<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\PersonalData\PersonalDataRequest;
use App\Models\PersonalData;
use App\Models\User;
use App\Repositories\Student\SchoolReportRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PersonalDataController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected StudentRegistrationRepository $studentRegistrationRepository;
    protected SchoolReportRepository $schoolReportRepository;

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository, SchoolReportRepository $schoolReportRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
        $this->schoolReportRepository = $schoolReportRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('personal-data-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('personal-data-write'), only: ['store']),
        ];
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Manajemen Siswa';
        $user->load('personalData', 'student.educationalInstitution.registrationSetting');
        $menus = $this->studentRegistrationRepository->menus($user);
        $schoolReportIsCompleted = $this->schoolReportRepository->isComplete($user);

        return view('dashboard.student.personal-data.index', compact('title', 'user', 'menus', 'schoolReportIsCompleted'));
    }

    public function store(PersonalDataRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $personalData = PersonalData::query()
                ->userId($user->id)
                ->firstOrNew();
            $personalData->user_id = $user->id;
            $personalData->place_of_birth = $request->input('place_of_birth');
            $personalData->date_of_birth = $request->input('date_of_birth');
            $personalData->gender = $request->input('gender');
            $personalData->child_to = $request->input('child_to');
            $personalData->number_of_brothers = $request->input('number_of_brothers');
            $personalData->family_relationship = $request->input('family_relationship');
            $personalData->religion = $request->input('religion');
            $personalData->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $personalData, route('personal-data.index', $user->username), Response::HTTP_OK);
    }
}
