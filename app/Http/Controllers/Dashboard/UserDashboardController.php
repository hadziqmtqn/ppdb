<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    public function index(): View
    {
        $title = 'Dashboard';

        return \view('dashboard.user-dashboard.index', compact('title'));
    }
}
