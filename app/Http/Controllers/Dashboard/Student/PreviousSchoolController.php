<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\PreviousSchool\PreviousSchoolRequest;
use App\Models\PreviousSchool;
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

class PreviousSchoolController extends Controller implements HasMiddleware
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
            new Middleware(PermissionMiddleware::using('previous-school-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('previous-school-write'), only: ['store']),
        ];
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Siswa';
        $user->load('previousSchool.educationalGroup:id,name', 'student.educationalInstitution.registrationSetting');
        $menus = $this->studentRegistrationRepository->menus($user);
        $schoolReportIsCompleted = $this->schoolReportRepository->isComplete($user);

        return \view('dashboard.student.previous-school.index', compact('title', 'user', 'menus', 'schoolReportIsCompleted'));
    }

    public function store(PreviousSchoolRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->load('schoolReports', 'previousSchool');

            if (($user->schoolReports && $user->schoolReports->isNotEmpty()) && (optional($user->previousSchool)->educational_group_id != $request->input('educational_group_id'))) {
                return $this->apiResponse('Tidak boleh mengubah Kelompok Pendidikan jika sudah mengisi Nilai Rapor', null, null, Response::HTTP_BAD_REQUEST);
            }

            $previousSchool = PreviousSchool::query()
                ->userId($user->id)
                ->firstOrNew();
            $previousSchool->user_id = $user->id;
            $previousSchool->school_name = $request->input('school_name');
            $previousSchool->educational_group_id = $request->input('educational_group_id');
            $previousSchool->status = $request->input('status');
            $previousSchool->province = $request->input('province');
            $previousSchool->city = $request->input('city');
            $previousSchool->district = $request->input('district');
            $previousSchool->village = $request->input('village');
            $previousSchool->street = $request->input('street');
            $previousSchool->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $previousSchool, route('previous-school.index', $user->username), Response::HTTP_OK);
    }
}
