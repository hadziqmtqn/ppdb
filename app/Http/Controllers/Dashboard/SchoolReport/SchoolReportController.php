<?php

namespace App\Http\Controllers\Dashboard\SchoolReport;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolReport\SchoolReportRequest;
use App\Models\DetailSchoolReport;
use App\Models\SchoolReport;
use App\Models\User;
use App\Repositories\Student\SchoolReportRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SchoolReportController extends Controller
{
    use AuthorizesRequests, ApiResponse;

    protected StudentRegistrationRepository $studentRegistrationRepository;
    protected SchoolReportRepository $schoolReportRepository;

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository, SchoolReportRepository $schoolReportRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
        $this->schoolReportRepository = $schoolReportRepository;
    }

    public function index(User $user): View
    {
        $this->authorize('view-student', $user);
        $title = 'Siswa';
        $user->load('student.educationalInstitution:id,name', 'previousSchool');
        $menus = $this->studentRegistrationRepository->menus($user);
        $schoolReports = $this->schoolReportRepository->getLessons($user);

        return \view('dashboard.student.school-report.index', compact('title', 'user', 'menus', 'schoolReports'));
    }

    /**
     * @throws Throwable
     */
    public function store(SchoolReportRequest $request, User $user): JsonResponse
    {
        $this->authorize('store', $user);

        try {
            DB::beginTransaction();
            // TODO School Report
            $schoolReport = SchoolReport::filterData([
                'user_id' => $user->id,
                'semester' => $request->input('semester')
            ])
                ->firstOrNew();
            $schoolReport->user_id = $user->id;
            $schoolReport->semester = $request->input('semester');
            $schoolReport->save();

            $detailSchoolReport = DetailSchoolReport::schoolReportId($schoolReport->id)
                ->lessonId($request->input('lesson_id'))
                ->firstOrNew();
            $detailSchoolReport->school_report_id = $schoolReport->id;
            $detailSchoolReport->lesson_id = $request->input('lesson_id');
            $detailSchoolReport->score = $request->input('score');
            $detailSchoolReport->save();

            $schoolReport->total_score = DetailSchoolReport::schoolReportId($schoolReport->id)
                ->sum('score');
            $schoolReport->save();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Nilai Rapor gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Nilai Rapor gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function show(SchoolReport $schoolReport)
    {
        $this->authorize('view', $schoolReport);

        return $schoolReport;
    }

    public function update(SchoolReportRequest $request, SchoolReport $schoolReport)
    {
        $this->authorize('update', $schoolReport);

        $schoolReport->update($request->validated());

        return $schoolReport;
    }

    public function destroy(SchoolReport $schoolReport)
    {
        $this->authorize('delete', $schoolReport);

        $schoolReport->delete();

        return response()->json();
    }
}
