<?php

namespace App\Http\Controllers\Dashboard\References;

use App\Http\Controllers\Controller;
use App\Http\Requests\MediaFile\DetailMediaFileRequest;
use App\Models\DetailMediaFile;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;

class DetailMediaFileController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('media-file-write'), only: ['update'])
        ];
    }

    public function show(DetailMediaFile $detailMediaFile): View
    {
        $title = 'Media File';
        $detailMediaFile->load('mediaFile:id,name,is_active', 'educationalInstitution:id,name', 'registrationPath:id,name');

        return \view('dashboard.references.media-file.edit', compact('title', 'detailMediaFile'));
    }

    public function update(DetailMediaFileRequest $request, DetailMediaFile $detailMediaFile)
    {
        $detailMediaFileExist = DetailMediaFile::where([
            'media_file_id' => $detailMediaFile->media_file_id,
            'educational_institution_id' => $request->input('educational_institution_id'),
            'registration_path_id' => $request->input('registration_path_id')
        ])
            ->where('id', '!=', $detailMediaFile->id)
            ->exists();

        if ($detailMediaFileExist) return $this->apiResponse('Data telah tersedia', null, null, Response::HTTP_BAD_REQUEST);

        try {
            $detailMediaFile->load('mediaFile');

            DB::beginTransaction();
            $mediaFile = $detailMediaFile->mediaFile;
            $mediaFile->name = $request->input('name');
            $mediaFile->is_active = $request->input('is_active');
            $mediaFile->save();

            $detailMediaFile->educational_institution_id = $request->input('educational_institution_id');
            $detailMediaFile->registration_path_id = $request->input('registration_path_id');
            $detailMediaFile->save();
            DB::commit();
        }catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal disimpan!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil disimpan!', $detailMediaFile, route('media-file.index'), Response::HTTP_OK);
    }

    public function destroy(DetailMediaFile $detailMediaFile)
    {
        $detailMediaFile->delete();

        return response()->json();
    }
}
