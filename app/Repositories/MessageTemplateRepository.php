<?php

namespace App\Repositories;

use App\Models\MessageTemplate;
use App\Models\User;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MessageTemplateRepository
{
    use ApiResponse;

    protected MessageTemplate $messageTemplate;
    protected User $user;

    public function __construct(MessageTemplate $messageTemplate, User $user)
    {
        $this->messageTemplate = $messageTemplate;
        $this->user = $user;
    }

    public function select($request): JsonResponse
    {
        try {
            $messageTemplates = $this->messageTemplate
                ->educationalInstitutionId($request['educational_institution_id'])
                ->active()
                ->when($request['search'], function ($query) use ($request) {
                    $query->whereAny(['title'], 'LIKE', '%' . $request['search'] . '%');
                })
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $messageTemplates->map(function (MessageTemplate $messageTemplate) {
            return collect([
                'id' => $messageTemplate->id,
                'title' => $messageTemplate->title
            ]);
        }), null, Response::HTTP_OK);
    }

    public function selectUser($request): JsonResponse
    {
        try {
            $users = $this->user->whereHas('admin', function ($query) use ($request) {
                $query->where('educational_institution_id', $request['educational_institution_id']);
            })
                ->search($request)
                ->active()
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $users->map(function (User $user) {
            return collect([
                'id' => $user->id,
                'name' => $user->name
            ]);
        }), null, Response::HTTP_OK);
    }
}
