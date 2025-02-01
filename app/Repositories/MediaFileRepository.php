<?php

namespace App\Repositories;

use App\Models\MediaFile;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MediaFileRepository
{
    use ApiResponse;

    protected MediaFile $mediaFile;

    public function __construct(MediaFile $mediaFile)
    {
        $this->mediaFile = $mediaFile;
    }

    public function getFiles($educationalInstitutionId): array
    {
        $mediaFiles = $this->mediaFile->query()
            ->select(['file_code', 'name', 'educational_institutions', 'category'])
            ->get()
            ->filter(function (MediaFile $uploadFileCategory) use ($educationalInstitutionId) {
                // Konversi string JSON ke array, jika gagal jadikan array kosong
                $institutions = json_decode($uploadFileCategory->educational_institutions, true) ?? [];

                // Memeriksa apakah ID ada dalam `educational_institutions` atau jika category adalah 'semua_unit'
                if (empty($institutions) && $uploadFileCategory->category === 'semua_unit') {
                    return true; // Jika educational_institutions kosong, pastikan kita ambil berdasarkan kategori 'semua_unit'
                }

                // Memeriksa apakah ID ada dalam `educational_institutions`
                return in_array($educationalInstitutionId, $institutions);
            });

        $file = [];
        foreach ($mediaFiles as $uploadFileCategory) {
            $file[$uploadFileCategory->file_code] = $uploadFileCategory->name;
        }

        return $file;
    }

    public function getMediaFiles($request): JsonResponse
    {
        $search = $request['search'];

        try {
            $mediaFiles = $this->mediaFile->when($search, function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->select(['id', 'name'])
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $mediaFiles->map(function (MediaFile $mediaFile) {
            return [
                'id' => $mediaFile->id,
                'name' => $mediaFile->name
            ];
        }), null, Response::HTTP_OK);
    }
}
