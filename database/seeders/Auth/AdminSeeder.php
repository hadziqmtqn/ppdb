<?php

namespace Database\Seeders\Auth;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        // Super Admin Role
        $superAdminRole = Role::create([
            'slug' => Str::uuid()->toString(),
            'name' => 'super-admin'
        ]);
        $superAdminRole->syncPermissions(Permission::all());

        $superAdmin = new User();
        $superAdmin->name = 'Super Admin';
        $superAdmin->email = 'superadmin@bkn.my.id';
        $superAdmin->password = Hash::make('superadmin');
        $superAdmin->account_verified = true;
        $superAdmin->save();

        $superAdmin->assignRole($superAdminRole);

        $admin = new Admin();
        $admin->user_id = $superAdmin->id;
        $admin->whatsapp_number = '082337724632';
        $admin->save();

        // Admin Role
        $adminRole = Role::create([
            'slug' => Str::uuid()->toString(),
            'name' => 'admin'
        ]);

        // User Role
        Role::create([
            'slug' => Str::uuid()->toString(),
            'name' => 'user'
        ]);

        // Admin seeder
        $rows = Reader::createFromPath(database_path('import/admin.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $user = new User();
            $user->name = $row['name'];
            $user->email = $row['email'];
            $user->password = Hash::make($row['password']);
            $user->save();

            $user->assignRole($adminRole);

            $detailAdmin = new Admin();
            $detailAdmin->user_id = $user->id;
            $detailAdmin->educational_institution_id = $row['educational_institution_id'];
            $detailAdmin->whatsapp_number = $row['whatsapp_number'];
            $detailAdmin->save();
        }
    }
}
