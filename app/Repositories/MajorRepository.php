<?php

namespace App\Repositories;

use App\Models\Major;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MajorRepository
{
    use ApiResponse;

    protected Major $major;

    public function __construct(Major $major)
    {
        $this->major = $major;
    }

    public function select($request): JsonResponse
    {
        try {
            $majors = $this->major->query()
                ->educationalInstitutionId($request['educational_institution_id'])
                ->active()
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $majors->map(function (Major $major) {
            return collect([
                'id' => $major->id,
                'name' => $major->name
            ]);
        }), null, Response::HTTP_OK);
    }
}
