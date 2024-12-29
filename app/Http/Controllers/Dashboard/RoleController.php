<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\UpdateRequest;
use App\Repositories\ModelRepository;
use App\Repositories\RoleRepository;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use ReflectionException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    protected RoleRepository $roleRepository;
    protected ModelRepository $modelRepository;

    public function __construct(RoleRepository $roleRepository, ModelRepository $modelRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->modelRepository = $modelRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware('role:super-admin'),
        ];
    }

    public function index(): View
    {
        $title = 'Role';
        $roles = $this->roleRepository->all();

        return view('dashboard.role.index', compact('title', 'roles'));
    }

    /**
     * @throws ReflectionException
     */
    public function edit(Role $role): View
    {
        $title = 'Role';
        $role->load('permissions');
        $models = $this->modelRepository->getAllModelsFromClassmap();

        return view('dashboard.role.edit', compact('title', 'role', 'models'));
    }

    public function update(UpdateRequest $request, Role $role)
    {
        try {
            $permissions = $request->input('permissions', []);

            // Buat permission jika belum ada
            $permissionIds = [];
            foreach ($permissions as $permissionName) {
                $permission = Permission::where('name', $permissionName)
                    ->first();

                if (!$permission) {
                    $permission = Permission::create([
                        'slug' => Str::uuid()->toString(),
                        'name' => $permissionName
                    ]);
                }

                $permissionIds[] = $permission->id; // Simpan ID permission untuk sinkronisasi
            }

            // Sinkronkan permission dengan role
            $role->syncPermissions($permissionIds);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}
