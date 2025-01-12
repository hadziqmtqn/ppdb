<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\Education\EducationRequest;
use App\Models\Education;
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

class EducationController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('education-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('education-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('education-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Pendidikan';

        return \view('dashboard.references.education.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = Education::query()
                    ->withCount('fatherEducations', 'motherEducations', 'guardianEducations')
                    ->orderBy('id');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<button href="javascript:void(0)" data-slug="'. $row->slug .'" data-name="'. $row->name .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        if (($row->father_educations_count == 0) && ($row->mother_educations_count == 0) && ($row->guardian_educations_count == 0)) {
                            $btn .= '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(EducationRequest $request): JsonResponse
    {
        try {
            $education = new Education();
            $education->name = $request->input('name');
            $education->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $education, null, Response::HTTP_OK);
    }

    public function update(EducationRequest $request, Education $education): JsonResponse
    {
        try {
            $education->name = $request->input('name');
            $education->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $education, null, Response::HTTP_OK);
    }

    public function destroy(Education $education): JsonResponse
    {
        try {
            $education->load('fatherEducations', 'motherEducations', 'guardianEducations');

            if ($education->fatherEducations->isNotEmpty() || $education->motherEducations->isNotEmpty() || $education->guardianEducations->isNotEmpty()) {
                return $this->apiResponse('Data tidak bisa dihapus', null, null, Response::HTTP_BAD_REQUEST);
            }

            $education->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
