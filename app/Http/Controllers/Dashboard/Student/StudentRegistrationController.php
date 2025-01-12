<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Student\StudentRegistrationRepository;
use Illuminate\Support\Facades\Gate;

class StudentRegistrationController extends Controller
{
    protected StudentRegistrationRepository $studentRegistrationRepository;

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
    }

    public function index(User $user)
    {
        Gate::authorize('view-student', $user);

        $title = 'Siswa';
        $user->load('student.educationalInstitution:id,name', 'student.educationalInstitution.majors', 'student.registrationCategory:id,name', 'student.registrationPath:id,name', 'student.major:id,name');
        $menus = $this->studentRegistrationRepository->menus($user);

        return view('dashboard.student.student-registration.index', compact('title', 'user', 'menus'));
    }
}
