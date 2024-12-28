<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        $title = 'Login';

        return view('home.auth.login', compact('title'));
    }
}
