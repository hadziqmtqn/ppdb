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
