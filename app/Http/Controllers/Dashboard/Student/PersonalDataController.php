<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalData\PersonalDataRequest;
use App\Models\PersonalData;
use App\Models\User;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;

class PersonalDataController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected StudentRegistrationRepository $studentRegistrationRepository;

    public function __construct(StudentRegistrationRepository $studentRegistrationRepository)
    {
        $this->studentRegistrationRepository = $studentRegistrationRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('personal-data-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('personal-data-write'), only: ['store']),
        ];
    }

    public function index(User $user): View
    {
        $title = 'Siswa';
        $user->load('student.educationalInstitution:id,name', 'student.educationalInstitution.majors', 'student.registrationCategory:id,name', 'student.registrationPath:id,name', 'student.major:id,name');
        $menus = $this->studentRegistrationRepository->menus($user);

        return view('dashboard.student.personal-data.index', compact('title', 'user', 'menus'));
    }

    public function store(PersonalDataRequest $request)
    {
        return PersonalData::create($request->validated());
    }
}
