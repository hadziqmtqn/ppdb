<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\Major\MajorRequest;
use App\Http\Requests\Major\SelectRequest;
use App\Http\Requests\Major\UpdateMajorRequest;
use App\Models\Major;
use App\Repositories\MajorRepository;
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

class MajorController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected MajorRepository $majorRepository;

    public function __construct(MajorRepository $majorRepository)
    {
        $this->majorRepository = $majorRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('major-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('major-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('major-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Jurusan';

        return \view('dashboard.references.major.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = Major::query()
                    ->with('educationalInstitution:id,name')
                    ->filterByEducationalInstitution();

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name)
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

    public function store(MajorRequest $request): JsonResponse
    {
        try {
            $major = new Major();
            $major->educational_institution_id = $request->input('educational_institution_id');
            $major->name = $request->input('name');
            $major->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $major, null, Response::HTTP_OK);
    }

    public function update(UpdateMajorRequest $request, Major $major): JsonResponse
    {
        try {
            $major->name = $request->input('name');
            $major->is_active = $request->input('is_active');
            $major->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $major, null, Response::HTTP_OK);
    }

    public function destroy(Major $major): JsonResponse
    {
        try {
            $major->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }

    public function select(SelectRequest $request)
    {
        return $this->majorRepository->select($request);
    }
}
