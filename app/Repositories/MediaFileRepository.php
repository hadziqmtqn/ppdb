<?php

namespace App\Repositories;

use App\Models\MediaFile;
use App\Models\Student;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Carbon;
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

    public function getFiles(Student $student): array
    {
        $mediaFiles = $this->mediaFile->query()
            ->whereHas('detailMediaFile', function ($query) use ($student) {
                $query->where(function ($query) use ($student) {
                    $query->where('educational_institution_id', $student->educational_institution_id)
                        ->whereNull('registration_path_id');
                })
                    ->orWhere(function ($query) use ($student) {
                        $query->where([
                            'educational_institution_id' => $student->educational_institution_id,
                            'registration_path_id' => $student->registration_path_id
                        ]);
                    });
            })
            ->orWhereDoesntHave('detailMediaFiles')
            ->select(['file_code', 'name'])
            ->active()
            ->get();

        $file = [];
        foreach ($mediaFiles as $uploadFileCategory) {
            $file[$uploadFileCategory->file_code] = [
                'fileName' => $uploadFileCategory->name,
                'fileUrl' => $student->hasMedia($uploadFileCategory->file_code) ? $student->getFirstTemporaryUrl(Carbon::now()->addMinutes(30), $uploadFileCategory->file_code) : null
            ];
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
