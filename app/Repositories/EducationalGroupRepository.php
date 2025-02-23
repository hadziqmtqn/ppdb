<?php

namespace App\Repositories;

use App\Models\EducationalGroup;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EducationalGroupRepository
{
    use ApiResponse;

    protected EducationalGroup $educationalGroup;

    public function __construct(EducationalGroup $educationalGroup)
    {
        $this->educationalGroup = $educationalGroup;
    }

    public function select($request): JsonResponse
    {
        try {
            $educationalGroups = $this->educationalGroup
                ->search($request)
                ->filter($request)
                ->get();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $educationalGroups->map(function (EducationalGroup $educationalGroup) {
            return collect([
                'id' => $educationalGroup->id,
                'name' => $educationalGroup->name
            ]);
        }), null, Response::HTTP_OK);
    }

    public function singleSelect($request): JsonResponse
    {
        try {
            $educationalGroups = $this->educationalGroup
                ->search($request)
                ->get();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $educationalGroups->map(function (EducationalGroup $educationalGroup) {
            return collect([
                'id' => $educationalGroup->id,
                'name' => $educationalGroup->name
            ]);
        }), null, Response::HTTP_OK);
    }
}
