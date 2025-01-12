<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class StudentRegistrationController extends Controller
{
    public function index(User $user)
    {
        Gate::authorize('view-student', $user);

        $title = 'Siswa';
        $user->load('student.educationalInstitution:id,name', 'student.registrationCategory:id,name', 'student.registrationPath:id,name', 'student.major:id,name');

        return view('dashboard.student.student-registration.index', compact('title', 'user'));
    }
}
