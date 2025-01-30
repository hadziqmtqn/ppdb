<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Residence\ResidenceRequest;
use App\Models\DistanceToSchool;
use App\Models\Residence;
use App\Models\Transportation;
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

class ResidenceController extends Controller implements HasMiddleware
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
            new Middleware(PermissionMiddleware::using('residence-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('residence-write'), only: ['store']),
        ];
    }

    public function index(User $user): View
    {
        Gate::authorize('view-student', $user);

        $title = 'Siswa';
        $user->load('residence');
        $menus = $this->studentRegistrationRepository->menus($user);
        $distanceToSchools = DistanceToSchool::select(['id', 'name'])
            ->get();
        $transportations = Transportation::select(['id', 'name'])
            ->get();

        return view('dashboard.student.residence.index', compact('title', 'user', 'menus', 'distanceToSchools', 'transportations'));
    }

    public function store(ResidenceRequest $request, User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $residence = Residence::query()
                ->userId($user->id)
                ->firstOrNew();
            $residence->user_id = $user->id;
            $residence->province = $request->input('province');
            $residence->city = $request->input('city');
            $residence->district = $request->input('district');
            $residence->village = $request->input('village');
            $residence->street = $request->input('street');
            $residence->postal_code = $request->input('postal_code');
            $residence->distance_to_school_id = $request->input('distance_to_school_id');
            $residence->transportation_id = $request->input('transportation_id');
            $residence->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $residence, route('place-of-recidence.index', $user->username), Response::HTTP_OK);
    }
}
