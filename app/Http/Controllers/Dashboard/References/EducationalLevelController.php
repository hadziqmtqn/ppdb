<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\EducationalLevel\EducationalLevelRequest;
use App\Models\EducationalLevel;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EducationalLevelController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.

        return [
            new Middleware(PermissionMiddleware::using('educational-level-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('educational-level-write'), only: ['update']),
        ];
    }

    public function index(): View
    {
        $title = 'Level Pendidikan';

        return view('dashboard.references.educational-level.index', compact('title'));
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = EducationalLevel::query();

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('action', function ($row) {
                        return '<button href="javascript:void(0)" data-slug="'. $row->slug .'" data-name="'. $row->name .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(EducationalLevelRequest $request, EducationalLevel $educationalLevel): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $educationalLevel->name = $request->input('name');
            $educationalLevel->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $educationalLevel, null, Response::HTTP_OK);
    }
}
