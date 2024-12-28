<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\MenuRequest;
use App\Models\Menu;
use App\Repositories\MenuRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller implements HasMiddleware
{
    protected MenuRepository $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.

        return [
            new Middleware(PermissionMiddleware::using('menu-read'), only: ['index', 'edit']),
            new Middleware(PermissionMiddleware::using('menu-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('menu-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'Menu';

        return view('dashboard.menu.index', compact('title'));
    }

    public function datatable(Request $request): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = Menu::query();

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['name'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('action', function ($row) {
                        return '<button href="javascript:void(0)" data-slug="' . $row->slug . '" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-trash-can-outline"></i></button>';
                    })
                    ->rawColumns(['action'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
    }

    public function store(MenuRequest $request)
    {
        try {
            $menu = new Menu();
            $menu->name = $request->input('name');
            $menu->type = $request->input('type');
            $menu->main_menu = $request->input('main_menu');
            $menu->visibility = json_encode($request->input('visibility'));
            $menu->url = $request->input('url');
            $menu->icon = $request->input('icon');
            $menu->save();
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function edit(Menu $menu)
    {
        return $menu;
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        return $menu;
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json();
    }

    public function select(Request $request)
    {
        return $this->menuRepository->getMainMenu($request);
    }
}
