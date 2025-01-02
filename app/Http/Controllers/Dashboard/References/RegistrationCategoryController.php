<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationCategory\RegistrationCategoryRequest;
use App\Http\Requests\RegistrationCategory\UpdateRegistrationCategoryRequest;
use App\Models\RegistrationCategory;
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

class RegistrationCategoryController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('registration-category-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('registration-category-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('registration-category-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Kategori Pendaftaran';

        return \view('dashboard.references.registration-category.index', compact('title'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = RegistrationCategory::query()
                    ->withCount('classLevels');

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
                        if ($row->class_levels_count == 0) {
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

    public function store(RegistrationCategoryRequest $request)
    {
        try {
            $registrationCategory = new RegistrationCategory();
            $registrationCategory->name = $request->input('name');
            $registrationCategory->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function update(UpdateRegistrationCategoryRequest $request, RegistrationCategory $registrationCategory): JsonResponse
    {
        try {
            $registrationCategory->name = $request->input('name');
            $registrationCategory->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $registrationCategory, null, Response::HTTP_OK);
    }

    public function destroy(RegistrationCategory $registrationCategory): JsonResponse
    {
        try {
            $registrationCategory->load('classLevels');

            if ($registrationCategory->classLevels->isNotEmpty()) return $this->apiResponse('Data tidak bisa dihapus', null, null, Response::HTTP_BAD_REQUEST);

            $registrationCategory->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
