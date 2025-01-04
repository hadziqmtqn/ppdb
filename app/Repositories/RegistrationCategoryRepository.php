<?php

namespace App\Repositories;

use App\Models\RegistrationCategory;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegistrationCategoryRepository
{
    use ApiResponse;

    protected RegistrationCategory $registrationCategory;

    public function __construct(RegistrationCategory $registrationCategory)
    {
        $this->registrationCategory = $registrationCategory;
    }

    public function select($request): JsonResponse
    {
        try {
            $registrationCategories = $this->registrationCategory->query()
                ->when($request['search'], function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request['search'] . '%');
                })
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $registrationCategories->map(function (RegistrationCategory $registrationCategory) {
            return collect([
                'id' => $registrationCategory->id,
                'name' => $registrationCategory->name
            ]);
        }), null, Response::HTTP_OK);
    }
}
