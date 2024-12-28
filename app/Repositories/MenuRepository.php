<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Collection;
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
                ->filterByType('main_menu')
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

    public function getMenus(): Collection
    {
        return $this->menu
            ->filterByType('main_menu')
            ->orderBy('serial_number')
            ->get()
            ->map(function (Menu $menu) {
                return collect([
                    'name' => $menu->name,
                    'type' => $menu->type,
                    'icon' => $menu->icon,
                    'url' => url($menu->url),
                    'visibility' => json_decode($menu->visibility),
                    'subMenus' => $this->menu->filterByType('sub_menu')
                        ->mainMenu($menu->id)
                        ->orderBy('serial_number')
                        ->get()
                        ->map(function (Menu $subMenu) {
                            return collect([
                                'name' => $subMenu->name,
                                'type' => $subMenu->type,
                                'icon' => $subMenu->icon,
                                'url' => url($subMenu->url),
                                'visibility' => json_decode($subMenu->visibility),
                            ]);
                    })
                ]);
            });
    }
}
