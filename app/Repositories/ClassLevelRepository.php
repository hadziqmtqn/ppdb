<?php

namespace App\Repositories;

use App\Models\ClassLevel;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ClassLevelRepository
{
    use ApiResponse;

    protected ClassLevel $classLevel;

    public function __construct(ClassLevel $classLevel)
    {
        $this->classLevel = $classLevel;
    }

    public function select($request): JsonResponse
    {
        try {
            $classLevels = $this->classLevel->query()
                ->educationalInstitutionId((!empty($request['educational_institution_id']) ? $request['educational_institution_id'] : null))
                ->registrationCategoryId((!empty($request['registration_category_id']) ? $request['registration_category_id'] : null))
                ->when($request['search'], function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request['search'] . '%');
                })
                ->active()
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $classLevels->map(function (ClassLevel $classLevel) {
            return collect([
                'id' => $classLevel->id,
                'name' => $classLevel->name
            ]);
        }), null, Response::HTTP_OK);
    }
}
