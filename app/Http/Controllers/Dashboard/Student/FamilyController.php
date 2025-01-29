<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Family\FamilyRequest;
use App\Models\Family;
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

class FamilyController extends Controller implements HasMiddleware
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
            new Middleware(PermissionMiddleware::using('family-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('family-write'), only: ['store']),
        ];
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Siswa';
        $user->load('family');
        $menus = $this->studentRegistrationRepository->menus($user);

        return view('dashboard.student.family.index', compact('title', 'user', 'menus'));
    }

    public function store(FamilyRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $family = Family::query()
                ->userId($user->id)
                ->firstOrNew();

            $family->user_id = $user->id;
            $family->national_identification_number = $request->input('national_identification_number');
            $family->family_card_number = $request->input('family_card_number');
            $family->father_name = $request->input('father_name');
            $family->father_education_id = $request->input('father_education_id');
            $family->father_profession_id = $request->input('father_profession_id');
            $family->father_income_id = $request->input('father_income_id');
            $family->mother_name = $request->input('mother_name');
            $family->mother_education_id = $request->input('mother_education_id');
            $family->mother_profession_id = $request->input('mother_profession_id');
            $family->mother_income_id = $request->input('mother_income_id');
            $family->have_a_guardian = $request->input('have_a_guardian');
            $family->guardian_name = $request->input('have_a_guardian') == 1 ? $request->input('guardian_name') : null;
            $family->guardian_education_id = $request->input('have_a_guardian') == 1 ? $request->input('guardian_education_id') : null;
            $family->guardian_profession_id = $request->input('have_a_guardian') == 1 ? $request->input('guardian_profession_id') : null;
            $family->guardian_income_id = $request->input('have_a_guardian') == 1 ? $request->input('guardian_income_id') : null;
            $family->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $family, route('family.index', $user->username), Response::HTTP_OK);
    }
}
