<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\PreviousSchool\PreviousSchoolRequest;
use App\Models\PreviousSchool;
use App\Models\PreviousSchoolReference;
use App\Models\User;
use App\Repositories\Student\SchoolReportRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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

        $title = 'Manajemen Siswa';
        $user->load('previousSchool.previousSchoolReference', 'student.educationalInstitution.registrationSetting');
        $menus = $this->studentRegistrationRepository->menus($user);
        $schoolReportIsCompleted = $this->schoolReportRepository->isComplete($user);

        return \view('dashboard.student.previous-school.index', compact('title', 'user', 'menus', 'schoolReportIsCompleted'));
    }

    /**
     * @throws Throwable
     */
    public function store(PreviousSchoolRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->load('schoolReports', 'previousSchool');

            DB::beginTransaction();
            if ($request->input('create_new')) {
                $previousSchoolReference = new PreviousSchoolReference();
                $previousSchoolReference->educational_group_id = $request->input('educational_group_id');
                $previousSchoolReference->province = $request->input('province');
                $previousSchoolReference->city = $request->input('city');
                $previousSchoolReference->district = $request->input('district');
                $previousSchoolReference->village = $request->input('village');
                $previousSchoolReference->street = $request->input('street');
                $previousSchoolReference->name = $request->input('school_name');
                $previousSchoolReference->status = $request->input('status');
                $previousSchoolReference->save();
            }else {
                $previousSchoolReference = PreviousSchoolReference::findOrFail($request->input('previous_school_reference_id'));
            }

            $previousSchool = PreviousSchool::query()
                ->userId($user->id)
                ->firstOrNew();
            $previousSchool->user_id = $user->id;
            $previousSchool->previous_school_reference_id = $previousSchoolReference->id;
            $previousSchool->save();

            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $previousSchool, route('previous-school.index', $user->username), Response::HTTP_OK);
    }
}
