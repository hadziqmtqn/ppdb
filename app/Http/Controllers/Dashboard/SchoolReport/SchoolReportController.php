<?php

namespace App\Http\Controllers\Dashboard\SchoolReport;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolReport\SchoolReportRequest;
use App\Models\SchoolReport;
use App\Models\User;
use App\Repositories\Student\SchoolReportRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

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
        $title = 'Rapor Sekolah';
        $user->load('student.educationalInstitution:id,name', 'previousSchool');
        $menus = $this->studentRegistrationRepository->menus($user);
        $schoolReports = $this->schoolReportRepository->getLessons($user);
        dd($schoolReports);

        return \view('dashboard.student.school-report.index', compact('title', 'user', 'menus'));
    }

    public function store(SchoolReportRequest $request)
    {
        $this->authorize('create', SchoolReport::class);

        return SchoolReport::create($request->validated());
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
