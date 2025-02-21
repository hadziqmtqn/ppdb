<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolReport\SchoolReportRequest;
use App\Models\DetailSchoolReport;
use App\Models\RegistrationSetting;
use App\Models\SchoolReport;
use App\Models\User;
use App\Repositories\Student\SchoolReportRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

            // TODO Total Score
            $totalGeneralLesson = DetailSchoolReport::whereHas('lesson', fn($query) => $query->where('type', 'umum'))
                ->schoolReportId($schoolReport->id)
                ->sum('score');

            $avgScoreReligiousStudy = DetailSchoolReport::whereHas('lesson', fn($query) => $query->where('type', 'keagamaan'))
                ->schoolReportId($schoolReport->id)
                ->avg('score');

            $schoolReport->total_score = $totalGeneralLesson + $avgScoreReligiousStudy;
            $schoolReport->save();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Nilai Rapor gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Nilai Rapor berhasil disimpan!', [
            'slug' => $schoolReport->slug
        ], null, Response::HTTP_OK);
    }

    public function storeReportFile(Request $request, User $user): JsonResponse
    {
        try {
            $user->load('student');
            $registrationSetting = RegistrationSetting::educationalInstitutionId(optional($user->student)->educational_institution_id)
                ->acceptedWithSchoolReport()
                ->first();
            $schoolReport = SchoolReport::filterBySlug($request->input('slug'))
                ->firstOrFail();

            if (!$registrationSetting) return $this->apiResponse('Cek kembali pengaturan registrasi', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);

            $reportSemesterFiles = json_decode($registrationSetting->school_report_semester, true);

            $fileUrl = null;
            foreach ($reportSemesterFiles as $reportSemesterFile) {
                $file = 'rapor_semester_' . $reportSemesterFile;
                if ($request->hasFile($file) && $request->file($file)->isValid()) {
                    if ($schoolReport->hasMedia($file)) {
                        $schoolReport->clearMediaCollection($file);
                    }

                    $schoolReport->addMediaFromRequest($file)
                        ->toMediaCollection($file);

                    $schoolReport->refresh();

                    $fileUrl = $schoolReport->getFirstTemporaryUrl(Carbon::now()->addHour(), $file);
                }
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('File gagal diupload', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('File berhasil diupload', [
            'slug' => $schoolReport->slug,
            'fileUrl' => $fileUrl
        ], null, Response::HTTP_OK);
    }

    public function deleteReportFile(Request $request, User $user): JsonResponse
    {
        try {
            $user->load('student');
            $schoolReport = SchoolReport::filterBySlug($request->input('slug'))
                ->firstOrFail();

            if ($schoolReport->hasMedia($request->input('file'))) {
                $schoolReport->clearMediaCollection($request->input('file'));
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('File gagal diupload', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('File berhasil diupload', null, null, Response::HTTP_OK);
    }
}
