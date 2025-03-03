<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\FilterRequest;
use App\Models\RegistrationSchedule;
use App\Models\User;
use App\Repositories\RegistrationScheduleRepository;
use App\Repositories\Student\SchoolReportRepository;
use App\Repositories\Student\StudentRegistrationRepository;
use App\Repositories\Student\StudentRepository;
use App\Repositories\Student\StudentStatsRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected StudentRepository $studentRepository;
    protected StudentRegistrationRepository $studentRegistrationRepository;
    protected StudentStatsRepository $studentStatsRepository;
    protected RegistrationScheduleRepository $registrationScheduleRepository;
    protected SchoolReportRepository $schoolReportRepository;

    public function __construct(StudentRepository $studentRepository, StudentRegistrationRepository $studentRegistrationRepository, StudentStatsRepository $studentStatsRepository, RegistrationScheduleRepository $registrationScheduleRepository, SchoolReportRepository $schoolReportRepository)
    {
        $this->studentRepository = $studentRepository;
        $this->studentRegistrationRepository = $studentRegistrationRepository;
        $this->studentStatsRepository = $studentStatsRepository;
        $this->registrationScheduleRepository = $registrationScheduleRepository;
        $this->schoolReportRepository = $schoolReportRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.

        return [
            new Middleware(PermissionMiddleware::using('student-read'), only: ['index', 'show']),
            new Middleware(PermissionMiddleware::using('student-delete'), only: ['destroy']),
            new Middleware('role:super-admin|admin', only: ['restore', 'permanentlyDelete', 'inactive'])
        ];
    }

    public function index(): View
    {
        $title = 'Manajemen Siswa';
        $stats = $this->studentStatsRepository->stats();

        return \view('dashboard.student.student.index', compact('title', 'stats'));
    }

    public function datatable(FilterRequest $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = User::query()
                    ->with('student.educationalInstitution', 'student.classLevel', 'student.major', 'student.registrationCategory', 'student.registrationPath', 'student.schoolYear')
                    ->filterStudentDatatable($request);

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name', 'email'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('registrationNumber', fn($row) => optional($row->student)->registration_number)
                    ->addColumn('educationalInstitution', fn($row) => optional(optional($row->student)->educationalInstitution)->name)
                    ->addColumn('registrationCategory', fn($row) => optional(optional($row->student)->registrationCategory)->name)
                    ->addColumn('whatsappNumber', fn($row) => optional($row->student)->whatsapp_number)
                    ->addColumn('registrationStatus', function ($row) {
                        $registrationStatus = optional($row->student)->registration_status;

                        $badgeColor = match ($registrationStatus) {
                            'belum_diterima' => 'bg-label-warning',
                            'diterima' => 'bg-label-primary',
                            default => 'bg-label-danger',
                        };

                        return '<span class="badge rounded-pill '. $badgeColor .'">'. ucfirst(str_replace('_', ' ', $registrationStatus)) .'</span>';
                    })
                    ->addColumn('registrationValidation', function ($row) {
                        $registrationValidation = optional($row->student)->registration_validation;

                        $badgeColor = match ($registrationValidation) {
                            'belum_divalidasi' => 'text-warning',
                            'valid' => 'text-primary',
                            default => 'text-danger',
                        };

                        return '<h6 class="mb-0 w-px-100 '. $badgeColor .'"><i class="mdi mdi-circle mdi-14px me-2"></i>'. ucfirst(str_replace('_', ' ', $registrationValidation)) .'</h6>';
                    })
                    ->addColumn('allCompleted', function ($row) {
                        $allCompeletd = $this->studentRegistrationRepository->allCompleted(User::withTrashed()->findOrFail($row->id));

                        return '<div class="d-inline-flex" data-bs-toggle="tooltip" title="'. ($allCompeletd ? 'Lengkap' : 'Tidak Lengkap') .'"><span class="avatar avatar-sm"> <span class="avatar-initial rounded-circle bg-label-'. ($allCompeletd ? 'success' : 'danger') .'"><i class="mdi mdi-'. ($allCompeletd ? 'check' : 'alert-rhombus-outline') .'"></i></span></span></div>';
                    })
                    ->addColumn('action', function ($row) {
                        $auth = Auth::user();
                        $btn = null;

                        if (!$row->deleted_at) {
                            $btn = '<a href="' . route('student.show', $row->username) . '" class="btn btn-icon btn-sm btn-primary"><i class="mdi mdi-eye"></i></a> ';
                            $btn .= '<a href="' . route('student-registration.index', $row->username) . '" class="btn btn-icon btn-sm btn-warning"><i class="mdi mdi-pencil-outline"></i></a> ';
                            if (!$auth->hasRole('user') && (optional($row->student)->registration_status != 'diterima')) {
                                $btn .= '<button type="button" data-username="' . $row->username . '" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-trash-can-outline"></i></button>';
                            }
                        }else {
                            if (!$auth->hasRole('user')) {
                                $btn = '<button type="button" data-username="' . $row->username . '" class="restore btn btn-icon btn-sm btn-warning"><i class="mdi mdi-restore-alert"></i></button> ';
                                $btn .= '<button type="button" data-username="' . $row->username . '" class="force-delete btn btn-sm btn-danger"><i class="mdi mdi-trash-can-outline me-1"></i>Hapus Permanen</button>';
                            }
                        }

                        return $btn;
                    })
                    ->rawColumns(['allCompleted', 'registrationStatus', 'registrationValidation', 'action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function show(User $user)
    {
        Gate::authorize('view-student', $user);

        $title = 'Manajemen Siswa';
        $user->load([
            'student.user:id,name',
            'student.educationalInstitution:id,name',
            'student.educationalInstitution.registrationSetting',
            'student.registrationCategory:id,name',
            'student.registrationPath:id,name',
            'student.major:id,name',
            'personalData',
            'family',
            'residence',
            'previousSchool.previousSchoolReference'
        ]);

        if (!$user->student) {
            return to_route('student.index')->with('warning', 'Ini bukan data siswa');
        }

        // TODO Photo Url
        $student = optional($user->student);
        $photoUrl = url('https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF');

        if ($student->hasMedia('pas-foto')) {
            $media = $student->getFirstMedia('pas-foto');

            if ($media && Str::startsWith($media->mime_type, 'image/')) {
                $photoUrl = $media->getTemporaryUrl(Carbon::now()->addMinutes(30));
            }
        }

        // TODO Detail data
        $registrations = $this->studentRepository->registration($user);
        $personalData = $this->studentRepository->personalData($user);
        $families = $this->studentRepository->family($user);
        $residences = $this->studentRepository->resicende($user);
        $previousSchools = $this->studentRepository->previousSchool($user);
        $mediaFiles = $this->studentRegistrationRepository->getFiles($user->student);

        // TODO Registration
        $registrationValidation = $this->studentRegistrationRepository->registrationValidationStatus($user->student);
        $registrationStatus = $this->studentRegistrationRepository->registrationStatus($user->student);

        // TODO School Report
        $schoolReports = $this->schoolReportRepository->getByUser($user);

        return \view('dashboard.student.student.show', compact('title', 'user', 'registrations', 'personalData', 'families', 'residences', 'previousSchools', 'mediaFiles', 'photoUrl', 'registrationValidation', 'registrationStatus', 'schoolReports'));
    }

    public function inactive(User $user)
    {
        try {
            $user->is_active = !$user->is_active;
            $user->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function destroy(User $user): JsonResponse
    {
        Gate::authorize('store', $user);

        try {
            $user->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }

    public function restore($username): JsonResponse
    {
        $user = User::filterByUsername($username)
            ->onlyTrashed()
            ->firstOrFail();

        Gate::authorize('student-destroy', $user);

        try {
            $user->restore();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dikembalikan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dikembalikan!', null, null, Response::HTTP_OK);
    }

    /**
     * @throws Throwable
     */
    public function permanentlyDelete($username): JsonResponse
    {
        $user = User::with('student')
            ->whereHas('student')
            ->filterByUsername($username)
            ->onlyTrashed()
            ->firstOrFail();

        Gate::authorize('student-destroy', $user);

        try {
            DB::beginTransaction();
            // TODO sync quota
            $registrationSchedule = RegistrationSchedule::filterData([
                'educational_institution_id' => optional($user->student)->educational_institution_id,
                'school_year_id' => optional($user->student)->school_year_id
            ])
                ->firstOrFail();

            $this->registrationScheduleRepository->syncQuota($registrationSchedule);

            // TODO force delete
            $user->forceDelete();
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dikembalikan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dikembalikan!', null, null, Response::HTTP_OK);
    }
}
