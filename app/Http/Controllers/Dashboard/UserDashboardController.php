<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Student\SchoolReportRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    protected StudentRegistrationRepository $studentRegistrationRepository;
    protected SchoolReportRepository $schoolReportRepository;

    /**
     * UserDashboardController constructor.
     * @param StudentRegistrationRepository $studentRegistrationRepository
     * @param SchoolReportRepository $schoolReportRepository
     */

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository, SchoolReportRepository $schoolReportRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
        $this->schoolReportRepository = $schoolReportRepository;
    }

    public function index(): View
    {
        $title = 'Dashboard';
        $user = User::with('student.educationalInstitution.registrationSetting')
            ->findOrFail(Auth::id());
        $mainProgress = $this->studentRegistrationRepository->menus($user);
        $schoolReportProgress = $this->schoolReportRepository->isComplete($user);

        return \view('dashboard.user-dashboard.index', compact('title', 'user', 'mainProgress', 'schoolReportProgress'));
    }
}
