<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller implements HasMiddleware
{
    protected RoleRepository $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('role-read'), only: ['index', 'edit']),
            new Middleware(PermissionMiddleware::using('role-write'), only: ['store', 'update']),
        ];
    }

    public function index(): View
    {
        $title = 'Role';
        $roles = $this->roleRepository->all();

        return view('dashboard.role.index', compact('title', 'roles'));
    }

    public function edit(Role $role): View
    {
        $title = 'Role';
        $role->load('permissions');
        $permissions = Permission::all();

        return view('dashboard.role.edit', compact('title', 'role', 'permissions'));
    }
}
