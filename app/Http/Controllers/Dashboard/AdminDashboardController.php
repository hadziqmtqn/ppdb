<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\Dashboard\AdminDashboardRepository;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    protected AdminDashboardRepository $adminDashboardRepository;

    /**
     * @param AdminDashboardRepository $adminDashboardRepository
     */
    public function __construct(AdminDashboardRepository $adminDashboardRepository)
    {
        $this->adminDashboardRepository = $adminDashboardRepository;
    }

    public function index(): View
    {
        $title = 'Dashboard';
        $totalBaseDatas = $this->adminDashboardRepository->totalBaseData();

        return view('dashboard.admin-dashboard.index', compact('title', 'totalBaseDatas'));
    }
}
