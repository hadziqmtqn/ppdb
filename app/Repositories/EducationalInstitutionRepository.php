<?php

namespace App\Repositories;

use App\Models\EducationalInstitution;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EducationalInstitutionRepository
{
    use ApiResponse;

    protected EducationalInstitution $educationalInstitution;

    public function __construct(EducationalInstitution $educationalInstitution)
    {
        $this->educationalInstitution = $educationalInstitution;
    }

    public function select($request): JsonResponse
    {
        try {
            $educationalInstitutions = $this->educationalInstitution
                ->when($request['search'], function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request['search'] . '%');
                })
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $educationalInstitutions->map(function (EducationalInstitution $educationalInstitution) {
            return collect([
                'id' => $educationalInstitution->id,
                'name' => $educationalInstitution->name
            ]);
        }), null, Response::HTTP_OK);
    }
}
