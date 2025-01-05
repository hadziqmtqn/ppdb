<?php

namespace App\Repositories;

use App\Models\SchoolYear;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SchoolYearRepository
{
    use ApiResponse;

    protected SchoolYear $schoolYear;

    public function __construct(SchoolYear $schoolYear)
    {
        $this->schoolYear = $schoolYear;
    }

    public function select($request): JsonResponse
    {
        try {
            $schoolYears = $this->schoolYear
                ->when($request['search'], function ($query) use ($request) {
                    $query->whereAny(['first_year', 'last_year'], 'like', '%' . $request['search'] . '%');
                })
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $schoolYears->map(function (SchoolYear $schoolYear) {
            return collect([
                'id' => $schoolYear->id,
                'year' => $schoolYear->first_year . '-' . $schoolYear->last_year
            ]);
        }), null, Response::HTTP_OK);
    }

    public function getSchoolYearActive(): Collection
    {
        $schoolYear = $this->schoolYear->active()
            ->firstOrFail();

        return collect([
            'year' => $schoolYear->first_year . '/' . $schoolYear->last_year
        ]);
    }
}
