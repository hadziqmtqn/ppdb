<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationalGroup\EducationalGroupRequest;
use App\Models\EducationalGroup;
use App\Repositories\EducationalGroupRepository;
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

class EducationalGroupController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected EducationalGroupRepository $educationalGroupRepository;

    /**
     * @param EducationalGroupRepository $educationalGroupRepository
     */
    public function __construct(EducationalGroupRepository $educationalGroupRepository)
    {
        $this->educationalGroupRepository = $educationalGroupRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('educational-group-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('educational-group-write'), only: ['store', 'update'])
        ];
    }

    public function index(): View
    {
        $title = 'Pengaturan Registrasi';
        $subTitle = 'Kelompok Pendidikan';

        return \view('dashboard.settings.registration-setting.educational-group.index', compact('title', 'subTitle'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = EducationalGroup::query()
                    ->with('nextEducationalLevel:id,name')
                    ->orderBy('next_educational_level_id');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('nextEducationalLevel', fn($row) => optional($row->nextEducationalLevel)->name)
                    ->addColumn('action', function ($row) {
                        return '<button type="button" data-slug="'. $row->slug .'" data-name="'. $row->name .'" data-next-educational-level="'. $row->next_educational_level_id .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(EducationalGroupRequest $request): JsonResponse
    {
        try {
            $educationalGroup = new EducationalGroup();
            $educationalGroup->name = $request->input('name');
            $educationalGroup->next_educational_level_id = $request->input('next_educational_level_id');
            $educationalGroup->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }

    public function update(EducationalGroupRequest $request, EducationalGroup $educationalGroup): JsonResponse
    {
        try {
            $educationalGroup->name = $request->input('name');
            $educationalGroup->next_educational_level_id = $request->input('next_educational_level_id');
            $educationalGroup->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', null, null, Response::HTTP_OK);
    }

    // TODO Select
    public function select(Request $request)
    {
        return $this->educationalGroupRepository->select($request);
    }

    public function singleSelect(Request $request)
    {
        return $this->educationalGroupRepository->singleSelect($request);
    }
}
