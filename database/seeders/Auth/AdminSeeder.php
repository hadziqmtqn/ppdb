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
        $role = Role::create([
            'slug' => Str::uuid()->toString(),
            'name' => 'super-admin'
        ]);
        $role->syncPermissions(Permission::all());

        $superAdmin = new User();
        $superAdmin->name = 'Super Admin';
        $superAdmin->email = 'superadmin@bkn.my.id';
        $superAdmin->password = Hash::make('superadmin');
        $superAdmin->save();
    }
}
