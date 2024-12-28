<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MenuRepository
{
    use ApiResponse;

    protected Menu $menu;

    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }

    public function getMainMenu($request): JsonResponse
    {
        try {
            $menus = $this->menu
                ->search($request)
                ->mainMenu()
                ->get();
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return $this->apiResponse('Internal server error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Success', $menus->map(function (Menu $menu) {
            return [
                'id' => $menu->id,
                'name' => $menu->name,
            ];
        }), null, Response::HTTP_OK);
    }

    public function getMenus()
    {
        return $this->menu
            ->mainMenu()
            ->orderBy('serial_number')
            ->get();
    }
}
