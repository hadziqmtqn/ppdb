<?php

namespace Database\Seeders\Auth;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin Role
        $role = Role::create([
            'slug' => Str::uuid()->toString(),
            'name' => 'super-admin'
        ]);
        $role->syncPermissions(Permission::all());

        $superAdmin = new User();
        $superAdmin->name = 'Super Admin';
        $superAdmin->email = 'superadmin@bkn.my.id';
        $superAdmin->password = Hash::make('superadmin');
        $superAdmin->account_verified = true;
        $superAdmin->save();

        $superAdmin->assignRole($role);

        // Admin Role
        Role::create([
            'slug' => Str::uuid()->toString(),
            'name' => 'admin'
        ]);

        // User Role
        Role::create([
            'slug' => Str::uuid()->toString(),
            'name' => 'user'
        ]);
    }
}
