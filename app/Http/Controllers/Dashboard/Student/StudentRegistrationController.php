<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudengRegistration\StudentRequest;
use App\Models\User;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentRegistrationController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('student-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('student-write'), only: ['store'])
        ];
    }

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

    public function store(StudentRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->load('student');

            DB::beginTransaction();
            $user->name = $request->input('name');
            $user->save();

            $student = $user->student;
            $student->registration_category_id = $request->input('registration_category_id');
            $student->registration_path_id = $request->input('registration_path_id');
            $student->class_level_id = $request->input('class_level_id');
            $student->major_id = $request->input('major_id');
            $student->nisn = $request->input('nisn');
            $student->whatsapp_number = $request->input('whatsapp_number');
            $student->save();
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $user, route('student-registration.index', $user->username), Response::HTTP_OK);
    }
}
