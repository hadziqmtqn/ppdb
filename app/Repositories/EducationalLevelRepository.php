<?php

namespace App\Repositories;

use App\Models\EducationalLevel;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EducationalLevelRepository
{
    use ApiResponse;

    protected EducationalLevel $educationalLevel;

    public function __construct(EducationalLevel $educationalLevel)
    {
        $this->educationalLevel = $educationalLevel;
    }

    public function select($request): JsonResponse
    {
        try {
            $educationalLevels = $this->educationalLevel
                ->when($request['search'], function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request['search'] . '%');
                })
                ->get();
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal Server Error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Success', $educationalLevels->map(function (EducationalLevel $educationalLevel) {
            return collect([
                'id' => $educationalLevel->id,
                'name' => $educationalLevel->name,
            ]);
        }), null, Response::HTTP_OK);
    }
}
