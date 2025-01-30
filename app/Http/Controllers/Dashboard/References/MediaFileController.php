<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaFile\MediaFileRequest;
use App\Models\EducationalInstitution;
use App\Models\MediaFile;
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

class MediaFileController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('media-file-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('media-file-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('media-file-delete'), only: ['destroy'])
        ];
    }

    public function index(): View
    {
        $title = 'Media File';
        $educationalInstitutions = EducationalInstitution::select(['id', 'name'])
            ->get();

        return \view('dashboard.references.media-file.index', compact('title', 'educationalInstitutions'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = MediaFile::query();

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('category', fn($row) => '<span class="badge '. ($row->category == 'semua_unit' ? 'bg-secondary' : 'bg-info') .'">'. ucfirst(str_replace('_', ' ', $row->category)) .'</span>')
                    ->addColumn('educationalInstitutions', function ($row) {
                        $badges = null;
                        if ($row->educational_institutions) {
                            $institutionIds = json_decode($row->educational_institutions, true);
                            $institutions = EducationalInstitution::whereIn('id', $institutionIds)
                                ->pluck('name');

                            $badges = '';
                            foreach ($institutions as $institution) {
                                $badges .= '<span class="badge bg-primary">'. $institution .'</span> ';
                            }
                        }

                        return $badges;
                    })
                    ->addColumn('is_active', fn($row) => '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>')
                    ->addColumn('action', function ($row) {
                        $btn = '<button href="javascript:void(0)" data-slug="'. $row->slug .'" data-name="'. $row->name .'" data-active="'. $row->is_active .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></button> ';
                        $btn .= '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'is_active', 'category', 'educationalInstitutions'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(MediaFileRequest $request): JsonResponse
    {
        try {
            $mediaFile = new MediaFile();
            $mediaFile->name = $request->input('name');
            $mediaFile->category = $request->input('category');
            $mediaFile->educational_institutions = $request->input('category') == 'unit_tertentu' ? json_encode(array_map('intval', $request->input('educational_institutions'))) : null;
            $mediaFile->save();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $mediaFile, null, Response::HTTP_OK);
    }

    public function show(MediaFile $file)
    {
        return $file;
    }

    public function update(MediaFileRequest $request, MediaFile $file)
    {
        $file->update($request->validated());

        return $file;
    }

    public function destroy(MediaFile $file)
    {
        $file->delete();

        return response()->json();
    }
}
