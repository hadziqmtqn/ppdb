<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Student\SchoolReportRepository;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Yajra\DataTables\Facades\DataTables;

class SchoolValueReportController extends Controller implements HasMiddleware
{
    use AuthorizesRequests;

    protected SchoolReportRepository $schoolReportRepository;

    /**
     * @param SchoolReportRepository $schoolReportRepository
     */
    public function __construct(SchoolReportRepository $schoolReportRepository)
    {
        $this->schoolReportRepository = $schoolReportRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('school-report-read'))
        ];
    }

    public function index(): View
    {
        $title = 'Nilai Raport';

        return \view('dashboard.student.school-value-report.index', compact('title'));
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $users = User::with('student:id,user_id,educational_institution_id,school_year_id', 'student.educationalInstitution:id,name', 'previousSchool:id,user_id,school_name,educational_group_id')
                    ->withSum('schoolReports', 'total_score')
                    ->whereHas('student')
                    ->whereHas('schoolReports')
                    ->get();

                // Sortir data berdasarkan total skor
                $users = $users->sortByDesc('school_reports_sum_total_score');

                // Filter data berdasarkan pencarian dan filter tambahan
                $search = $request->get('search');
                $schoolYear = $request->get('school_year_id');
                $educationalInstitution = $request->get('educational_institution_id');
                $educationalGroup = $request->get('educational_group_id');

                $users = $users->filter(function ($user) use ($search, $schoolYear, $educationalInstitution, $educationalGroup) {
                    $match = true;

                    if ($search) {
                        $match = stripos($user->name, $search) !== false;
                    }

                    if ($schoolYear) {
                        $match = $match && optional($user->student)->school_year_id == $schoolYear;
                    }

                    if ($educationalInstitution) {
                        $match = $match && optional($user->student)->educational_institution_id == $educationalInstitution;
                    }

                    if ($educationalGroup) {
                        $match = $match && optional($user->previousSchool)->educational_group_id == $educationalGroup;
                    }

                    return $match;
                });

                return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('educationalInstitution', fn($row) => optional(optional($row->student)->educationalInstitution)->name)
                    ->addColumn('previousSchool', fn($row) => optional($row->previousSchool)->school_name)
                    ->addColumn('totalScore', fn($row) => $row->school_reports_sum_total_score)
                    ->addColumn('action', function ($row) {
                        return '<a href="'. route('school-value-report.show', $row->username) .'" class="btn btn-icon btn-sm btn-secondary"><i class="mdi mdi-eye"></i></a>';
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function show(User $user): View
    {
        $this->authorize('view-student', $user);
        $title = 'Nilai Raport';
        $user->load('student.educationalInstitution', 'previousSchool.educationalGroup');
        $schoolReports = $this->schoolReportRepository->getByUser($user);

        return \view('dashboard.student.school-value-report.show', compact('title', 'schoolReports', 'user'));
    }
}
