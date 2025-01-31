<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.

        return [
            new Middleware(PermissionMiddleware::using('student-read'), only: ['index', 'show']),
            new Middleware(PermissionMiddleware::using('student-write'), only: ['update']),
            new Middleware(PermissionMiddleware::using('student-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Siswa';

        return \view('dashboard.student.student.index', compact('title'));
    }

    public function datatable(Request $request): JsonResponse
    {
        $auth = auth()->user();
        $role = $auth->roles->first()->name;

        try {
            if ($request->ajax()) {
                $data = User::query()
                    ->with('student.educationalInstitution', 'student.classLevel', 'student.major', 'student.registrationCategory', 'student.registrationPath', 'student.schoolYear')
                    ->when(($role == 'admin'),
                        // Admin: Filter berdasarkan educational institution
                        fn($query) => $query->whereHas('student', fn($query) =>
                        $query->where('educational_institution_id', optional($auth->admin)->educational_institution_id)
                        ),
                        // Bukan admin: Cek apakah user atau super-admin
                        fn($query) => $query->when(($role == 'user'),
                            // User: Filter berdasarkan ID user
                            fn($query) => $query->where('id', $auth->id),
                            // Super-admin: Semua student
                            fn($query) => $query->whereHas('student')
                        )
                    )
                    ->when($request->get('status'), function ($query) use ($request) {
                        $query->when($request->get('status') == 'active', function ($query) use ($request) {
                            $query->where('is_active', true);
                        })
                            ->when($request->get('status') == 'inactive', function ($query) use ($request) {
                                $query->where('is_active', false);
                            })
                            ->when($request->get('status') == 'deleted', function ($query) use ($request) {
                                $query->onlyTrashed();
                            });
                    });

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

                        $badge = match ($registrationStatus) {
                            'belum_diterima' => 'bg-warning',
                            'diterima' => 'bg-primary',
                            default => 'bg-danger',
                        };

                        return '<span class="badge rounded-pill '. $badge .'">'. strtoupper(str_replace('_', ' ', $registrationStatus)) .'</span>';
                    })
                    ->addColumn('is_active', function ($row) {
                        return '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>';
                    })
                    ->addColumn('action', function ($row) use ($auth) {
                        $btn = null;

                        if (!$row->deleted_at) {
                            $btn = '<a href="' . route('student.show', $row->username) . '" class="btn btn-icon btn-sm btn-primary"><i class="mdi mdi-eye"></i></a> ';
                            $btn .= '<a href="' . route('student-registration.index', $row->username) . '" class="btn btn-icon btn-sm btn-warning"><i class="mdi mdi-pencil-outline"></i></a> ';
                            if (!$auth->hasRole('user')) {
                                $btn .= '<button href="javascript:void(0)" data-username="' . $row->username . '" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-trash-can-outline"></i></button>';
                            }
                        }else {
                            if (!$auth->hasRole('user')) {
                                $btn .= '<button href="javascript:void(0)" data-username="' . $row->username . '" class="restore btn btn-icon btn-sm btn-warning"><i class="mdi mdi-restore-alert"></i></button> ';
                                $btn .= '<button href="javascript:void(0)" data-username="' . $row->username . '" class="force-delete btn btn-sm btn-danger"><i class="mdi mdi-trash-can-outline me-1"></i>Hapus Permanen</button>';
                            }
                        }

                        return $btn;
                    })
                    ->rawColumns(['is_active', 'registrationStatus', 'action'])
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

        $title = 'Siswa';
        $user->load('student.educationalInstitution:id,name', 'student.registrationCategory:id,name', 'student.registrationPath:id,name', 'student.major:id,name');

        if (!$user->student) {
            return to_route('student.index')->with('warning', 'Ini bukan data siswa');
        }

        return \view('dashboard.student.student.show', compact('title', 'user'));
    }

    public function destroy(Student $student): JsonResponse
    {
        try {
            $student->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
