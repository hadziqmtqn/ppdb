<?php

namespace App\Repositories;

use App\Models\RegistrationPath;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegistrationPathRepository
{
    use ApiResponse;

    protected RegistrationPath $registrationPath;

    public function __construct(RegistrationPath $registrationPath)
    {
        $this->registrationPath = $registrationPath;
    }

    public function select($request): JsonResponse
    {
        try {
            $registrationPaths = $this->registrationPath->query()
                ->educationalInstitutionId($request['educational_institution_id'])
                ->active()
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $registrationPaths->map(function (RegistrationPath $registrationPath) {
            return collect([
                'id' => $registrationPath->id,
                'name' => $registrationPath->name
            ]);
        }), null, Response::HTTP_OK);
    }
}
