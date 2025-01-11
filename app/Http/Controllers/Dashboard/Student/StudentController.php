<?php

namespace App\Http\Controllers\Dashboard\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
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
        try {
            if ($request->ajax()) {
                $data = User::query()
                    ->with('student')
                    ->whereHas('student')
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
                    ->addColumn('educationalInstitution', fn($row) => optional(optional($row->admin)->educationalInstitution)->name)
                    ->addColumn('role', fn($row) => '<span class="badge rounded-pill ' . ($row->roles->first()->name == 'super-admin' ? 'bg-primary' : 'bg-secondary') . '">'. ucfirst(str_replace('-', ' ', $row->roles->first()->name)) .'</span>')
                    ->addColumn('whatsappNumber', fn($row) => optional($row->admin)->whatsapp_number)
                    ->addColumn('is_active', function ($row) {
                        return '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>';
                    })
                    ->addColumn('action', function ($row) {
                        $btn = null;

                        if (!$row->deleted_at) {
                            $btn = '<a href="' . route('admin.show', $row->username) . '" class="btn btn-icon btn-sm btn-primary"><i class="mdi mdi-eye"></i></a> ';
                            if ($row->roles->first()->name != 'super-admin') {
                                $btn .= '<button href="javascript:void(0)" data-username="' . $row->username . '" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-trash-can-outline"></i></button>';
                            }
                        }else {
                            $btn .= '<button href="javascript:void(0)" data-username="' . $row->username . '" class="restore btn btn-icon btn-sm btn-warning"><i class="mdi mdi-restore-alert"></i></button> ';
                            $btn .= '<button href="javascript:void(0)" data-username="' . $row->username . '" class="force-delete btn btn-sm btn-danger"><i class="mdi mdi-trash-can-outline me-1"></i>Hapus Permanen</button>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['is_active', 'role', 'action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(StudentRequest $request)
    {
        return Student::create($request->validated());
    }

    public function show(Student $student)
    {
        return $student;
    }

    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        return $student;
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return response()->json();
    }
}
