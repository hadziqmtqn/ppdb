<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class RoleRepository
{
    protected Role $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function all(): Collection
    {
        return $this->role->get()->map(function (Role $role) {
            return collect([
                'slug' => $role->slug,
                'name' => ucfirst(str_replace('-', ' ', $role->name)),
                'usersCount' => $role->users()->count(),
            ]);
        });
    }
}
