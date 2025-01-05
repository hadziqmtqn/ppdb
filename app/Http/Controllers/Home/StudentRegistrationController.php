<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class StudentRegistrationController extends Controller
{
    public function index(): View
    {
        $title = 'Registrasi';

        return \view('home.register.index', compact('title'));
    }
}
