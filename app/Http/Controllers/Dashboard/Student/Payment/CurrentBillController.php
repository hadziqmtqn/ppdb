<?php

namespace App\Http\Controllers\Dashboard\Student\Payment;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Student\Payment\CurrentBillRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CurrentBillController extends Controller
{
    protected CurrentBillRepository $currentBillRepository;

    /**
     * @param CurrentBillRepository $currentBillRepository
     */
    public function __construct(CurrentBillRepository $currentBillRepository)
    {
        $this->currentBillRepository = $currentBillRepository;
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Tagihan Saat Ini';
        $user->load('student.educationalInstitution:id,name', 'student.schoolYear:id,first_year,last_year');
        $currentBills = $this->currentBillRepository->getRegistrationFee($user)
            ->get();

        return \view('dashboard.student.payment.current-bill.index', compact('title', 'user', 'currentBills'));
    }
}
