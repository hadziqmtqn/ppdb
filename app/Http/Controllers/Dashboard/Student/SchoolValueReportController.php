<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
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
                $users = User::with('student:id,user_id,educational_institution_id', 'student.educationalInstitution:id,name')
                    ->withSum('schoolReports', 'total_score')
                    ->whereHas('student')
                    ->whereHas('schoolReports')
                    ->get();

                // Sortir data berdasarkan total skor
                $users = $users->sortByDesc('school_reports_sum_total_score');

                // Filter data berdasarkan pencarian dan filter tambahan
                $search = $request->get('search');
                $email = $request->get('email');
                $institution = $request->get('institution');

                $users = $users->filter(function ($user) use ($search, $email, $institution) {
                    $match = true;

                    if ($search) {
                        $match = stripos($user->name, $search) !== false;
                    }

                    if ($email) {
                        $match = $match && stripos($user->email, $email) !== false;
                    }

                    if ($institution) {
                        $match = $match && optional(optional($user->student)->educationalInstitution)->name === $institution;
                    }

                    return $match;
                });

                return DataTables::of($users)
                    ->addIndexColumn()
                    ->addColumn('educationalInstitution', fn($row) => optional(optional($row->student)->educationalInstitution)->name)
                    ->addColumn('totalScore', fn($row) => $row->school_reports_sum_total_score)
                    ->addColumn('action', function ($row) {
                        return '<a href="#" class="btn btn-icon btn-sm btn-warning"><i class="mdi mdi-pencil-outline"></i></a> ';
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }
}
