<?php

namespace App\Repositories\References;

use App\Models\PreviousSchoolReference;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PreviousSchoolReferenceRepository
{
    use ApiResponse;

    protected PreviousSchoolReference $previousSchoolReference;

    public function __construct(PreviousSchoolReference $previousSchoolReference)
    {
        $this->previousSchoolReference = $previousSchoolReference;
    }

    public function select($request): JsonResponse
    {
        try {
            $previousSchoolReferences = $this->previousSchoolReference->search($request)
                ->filterData($request)
                ->get();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $previousSchoolReferences->map(function (PreviousSchoolReference $previousSchoolReference) {
            return collect([
                'id' => $previousSchoolReference->id,
                'name' => $previousSchoolReference->name . ' (' . $previousSchoolReference->status . ')'
            ]);
        }), null, Response::HTTP_OK);
    }
}
