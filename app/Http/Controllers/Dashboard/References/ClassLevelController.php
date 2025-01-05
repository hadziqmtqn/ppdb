<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassLevel\ClassLevelRequest;
use App\Http\Requests\ClassLevel\SelectRequest;
use App\Http\Requests\ClassLevel\UpdateClassLevelRequest;
use App\Models\ClassLevel;
use App\Repositories\ClassLevelRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ClassLevelController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected ClassLevelRepository $classLevelRepository;

    public function __construct(ClassLevelRepository $classLevelRepository)
    {
        $this->classLevelRepository = $classLevelRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('class-level-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('class-level-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('class-level-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Kelas';

        return \view('dashboard.references.class-level.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = ClassLevel::query()
                    ->with('educationalInstitution:id,name', 'registrationCategory:id,name')
                    ->orderBy('educational_institution_id')
                    ->orderBy('registration_category_id')
                    ->orderBy('code');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name)
                    ->addColumn('registrationCategory', fn($row) => optional($row->registrationCategory)->name)
                    ->addColumn('is_active', fn($row) => '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>')
                    ->addColumn('action', function ($row) {
                        $btn = '<button href="javascript:void(0)" data-slug="'. $row->slug .'" data-name="'. $row->name .'" data-active="'. $row->is_active .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        $btn .= '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'is_active'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(ClassLevelRequest $request): JsonResponse
    {
        try {
            $classLevel = new ClassLevel();
            $classLevel->educational_institution_id = $request->input('educational_institution_id');
            $classLevel->registration_category_id = $request->input('registration_category_id');
            $classLevel->name = $request->input('name');
            $classLevel->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $classLevel, null, Response::HTTP_OK);
    }

    public function update(UpdateClassLevelRequest $request, ClassLevel $classLevel): JsonResponse
    {
        try {
            $classLevel->name = $request->input('name');
            $classLevel->is_active = $request->input('is_active');
            $classLevel->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $classLevel, null, Response::HTTP_OK);
    }

    public function destroy(ClassLevel $classLevel): JsonResponse
    {
        try {
            $classLevel->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }

    public function select(SelectRequest $request)
    {
        return $this->classLevelRepository->select($request);
    }
}
