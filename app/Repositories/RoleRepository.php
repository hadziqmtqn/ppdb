<?php

namespace App\Repositories;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RoleRepository
{
    use ApiResponse;

    protected Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function select($request): JsonResponse
    {
        try {
            $roles = $this->role->query()
                ->when($request['search'], function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request['search'] . '%');
                })
                ->where('name', '!=', 'user')
                ->get();
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $roles->map(function (Role $role) {
            return collect([
                'slug' => $role->slug,
                'name' => ucfirst(str_replace('-', ' ', $role->name)),
            ]);
        }), null, Response::HTTP_OK);
    }
}
