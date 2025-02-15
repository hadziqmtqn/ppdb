<?php

namespace App\Repositories\Message;

use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ConversationRepository
{
    use ApiResponse;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getStudents($request): JsonResponse
    {
        $search = $request['search'] ?? null;
        $educationalInstitutionId = $request['educational_institution_id'] ?? null;

        try {
            $students = $this->user->whereHas('student.schoolYear', function ($query) {
                $query->where('is_active', true);
            })
                ->search($search)
                ->whereHas('student', fn($query) => $query->where('educational_institution_id', $educationalInstitutionId))
                ->active()
                ->get();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $students->map(function (User $user) {
            return [
                'id' => $user->id,
                'name' => $user->name
            ];
        }), null, Response::HTTP_OK);
    }
}
