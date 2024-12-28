<?php

namespace Database\Seeders;

use Database\Seeders\Auth\AdminSeeder;
use Database\Seeders\Auth\PermissionSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            AdminSeeder::class,
            ApplicationSeeder::class,
        ]);
    }
}
