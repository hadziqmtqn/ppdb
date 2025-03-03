<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistanceToSchool\DistanceToSchoolRequest;
use App\Models\DistanceToSchool;
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

class DistanceToSchoolController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.

        return [
            new Middleware(PermissionMiddleware::using('distance-to-school-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('distance-to-school-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('distance-to-school-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Jarak ke Sekolah';

        return \view('dashboard.references.distance-to-school.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = DistanceToSchool::query()
                    ->orderByDesc('created_at');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<button type="button" data-slug="'. $row->slug .'" data-name="'. $row->name .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        $btn .= '<button type="button" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

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

    public function store(DistanceToSchoolRequest $request): JsonResponse
    {
        try {
            $distanceToSchool = new DistanceToSchool();
            $distanceToSchool->name = $request->input('name');
            $distanceToSchool->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $distanceToSchool, null, Response::HTTP_OK);
    }

    public function update(DistanceToSchoolRequest $request, DistanceToSchool $distanceToSchool): JsonResponse
    {
        try {
            $distanceToSchool->name = $request->input('name');
            $distanceToSchool->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $distanceToSchool, null, Response::HTTP_OK);
    }

    public function destroy(DistanceToSchool $distanceToSchool): JsonResponse
    {
        try {
            $distanceToSchool->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
