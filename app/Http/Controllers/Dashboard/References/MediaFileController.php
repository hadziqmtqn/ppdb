<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaFile\MediaFileRequest;
use App\Models\DetailMediaFile;
use App\Models\EducationalInstitution;
use App\Models\MediaFile;
use App\Repositories\MediaFileRepository;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MediaFileController extends Controller implements HasMiddleware
{
    use ApiResponse;

    protected MediaFileRepository $mediaFileRepository;

    public function __construct(MediaFileRepository $mediaFileRepository)
    {
        $this->mediaFileRepository = $mediaFileRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('media-file-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('media-file-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('media-file-delete'), only: ['destroy'])
        ];
    }

    public function selectEducations()
    {
        return EducationalInstitution::select(['id', 'name'])
            ->get();
    }

    public function index(): View
    {
        $title = 'Media File';
        $educationalInstitutions = $this->selectEducations();

        return \view('dashboard.references.media-file.index', compact('title', 'educationalInstitutions'));
    }

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = MediaFile::query()
                    ->with('detailMediaFiles.educationalInstitution:id,name', 'detailMediaFiles.registrationPath:id,name');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('detailMediaFiles', function ($row) {
                        $badge = null;
                        $detailMediaFiles = $row->detailMediaFiles;

                        if ($detailMediaFiles->isNotEmpty()) {
                            $badge = '';
                            $colors = ['bg-primary', 'bg-secondary', 'bg-success', 'bg-danger', 'bg-warning', 'bg-info', 'bg-light', 'bg-dark'];
                            foreach ($detailMediaFiles as $detailMediaFile) {
                                $randomColor = $colors[array_rand($colors)];
                                if ($detailMediaFile->registration_path_id) {
                                    $badge .= '<div class="d-flex align-items-center lh-1 me-3 mb-3 mb-sm-1">
                                        <span class="badge badge-dot '. $randomColor .' me-1"></span> '. optional($detailMediaFile->educationalInstitution)->name . ($detailMediaFile->registrationPath ? ' - Jalur: ' . optional($detailMediaFile->registrationPath)->name : null) .'
                                        <a href="'. route('detail-media-file.show', $detailMediaFile->slug) .'" class="btn btn-xs btn-outline-warning ms-1" data-slug="'. $detailMediaFile->slug .'" data-educational-institution="'. $detailMediaFile->educational_institution_id .'" data-registration-path="'. $detailMediaFile->registration_path_id .'">Edit</a>
                                        <button href="javascript:void(0)" class="delete-detail-media-file btn btn-xs btn-outline-danger ms-1" data-slug="'. $detailMediaFile->slug .'">Hapus</button>
                                    </div>';
                                }
                            }
                        }

                        return $badge;
                    })
                    ->addColumn('is_active', fn($row) => '<span class="badge rounded-pill '. ($row->is_active ? 'bg-primary' : 'bg-danger') .'">'. ($row->is_active ? 'Aktif' : 'Tidak Aktif') .'</span>')
                    ->addColumn('action', function ($row) {
                        return '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';
                    })
                    ->rawColumns(['action', 'is_active', 'category', 'educationalInstitutions', 'detailMediaFiles'])
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
            DB::beginTransaction();
            if ($request->input('create_new') == 'YA') {
                $mediaFile = new MediaFile();
                $mediaFile->name = $request->input('name');
                $mediaFile->save();
            }else {
                $mediaFile = MediaFile::findOrFail($request->input('media_file_id'));
            }

            $detailMediaFile = new DetailMediaFile();
            $detailMediaFile->media_file_id = $mediaFile->id;
            $detailMediaFile->educational_institution_id = $request->input('educational_institution_id');
            $detailMediaFile->registration_path_id = $request->input('registration_path_id');
            $detailMediaFile->save();
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $mediaFile, null, Response::HTTP_OK);
    }

    public function destroy(MediaFile $mediaFile): JsonResponse
    {
        try {
            $mediaFile->delete();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }

    public function select(Request $request)
    {
        return $this->mediaFileRepository->getMediaFiles($request);
    }
}
