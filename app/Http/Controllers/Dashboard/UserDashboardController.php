<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\RegistrationFeeRepository;
use App\Repositories\Student\Payment\PaymentTransactionRepository;
use App\Repositories\Student\SchoolReportRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    protected StudentRegistrationRepository $studentRegistrationRepository;
    protected SchoolReportRepository $schoolReportRepository;
    protected RegistrationFeeRepository $registrationFeeRepository;
    protected PaymentTransactionRepository $paymentTransactionRepository;

    /**
     * UserDashboardController constructor.
     * @param StudentRegistrationRepository $studentRegistrationRepository
     * @param SchoolReportRepository $schoolReportRepository
     * @param RegistrationFeeRepository $registrationFeeRepository
     * @param PaymentTransactionRepository $paymentTransactionRepository
     */

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository, SchoolReportRepository $schoolReportRepository, RegistrationFeeRepository $registrationFeeRepository, PaymentTransactionRepository $paymentTransactionRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
        $this->schoolReportRepository = $schoolReportRepository;
        $this->registrationFeeRepository = $registrationFeeRepository;
        $this->paymentTransactionRepository = $paymentTransactionRepository;
    }

    public function index(): View
    {
        $title = 'Dashboard';
        $user = User::with('student.educationalInstitution.registrationSetting')
            ->findOrFail(Auth::id());
        $mainProgress = $this->studentRegistrationRepository->menus($user);
        $schoolReportProgress = $this->schoolReportRepository->isComplete($user);
        $activeRegistrationFee = $this->registrationFeeRepository->getActiveRegistrationFee($user);
        $paymentRegistrationExists = $this->paymentTransactionRepository->getPaymentRegistrationExists($user);

        return \view('dashboard.user-dashboard.index', compact('title', 'user', 'mainProgress', 'schoolReportProgress', 'activeRegistrationFee', 'paymentRegistrationExists'));
    }
}
