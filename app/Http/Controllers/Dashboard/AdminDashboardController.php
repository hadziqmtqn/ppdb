<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\AdminDashboardRepository;
use App\Repositories\Student\StudentStatsRepository;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    protected AdminDashboardRepository $adminDashboardRepository;
    protected StudentStatsRepository $studentStatsRepository;

    /**
     * @param AdminDashboardRepository $adminDashboardRepository
     * @param StudentStatsRepository $studentStatsRepository
     */
    public function __construct(AdminDashboardRepository $adminDashboardRepository, StudentStatsRepository $studentStatsRepository)
    {
        $this->adminDashboardRepository = $adminDashboardRepository;
        $this->studentStatsRepository = $studentStatsRepository;
    }

    public function index(): View
    {
        $title = 'Dashboard';
        $totalBaseDatas = $this->adminDashboardRepository->totalBaseData();
        $stats = $this->adminDashboardRepository->stats();

        return view('dashboard.admin-dashboard.index', compact('title', 'totalBaseDatas', 'stats'));
    }
}
