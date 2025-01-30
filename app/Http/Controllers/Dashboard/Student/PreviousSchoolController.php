<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\PreviousSchool\PreviousSchoolRequest;
use App\Models\PreviousSchool;
use App\Models\User;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PreviousSchoolController extends Controller implements HasMiddleware
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
            new Middleware(PermissionMiddleware::using('previous-school-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('previous-school-write'), only: ['store']),
        ];
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Siswa';
        $user->load('previousSchool');
        $menus = $this->studentRegistrationRepository->menus($user);

        return \view('dashboard.student.previous-school.index', compact('title', 'user', 'menus'));
    }

    public function store(PreviousSchoolRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $previousSchool = PreviousSchool::query()
                ->userId($user->id)
                ->firstOrNew();
            $previousSchool->user_id = $user->id;
            $previousSchool->school_name = $request->input('school_name');
            $previousSchool->status = $request->input('status');
            $previousSchool->province = $request->input('province');
            $previousSchool->city = $request->input('city');
            $previousSchool->district = $request->input('district');
            $previousSchool->village = $request->input('village');
            $previousSchool->street = $request->input('street');
            $previousSchool->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $previousSchool, route('previous-school.index', $user->username), Response::HTTP_OK);
    }
}
