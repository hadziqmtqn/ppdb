<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $title = 'Dashboard';

        return view('dashboard.admin-dashboard.index', compact('title'));
    }
}
