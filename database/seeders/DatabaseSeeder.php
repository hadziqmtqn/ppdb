<?php

namespace Database\Seeders;

use Database\Seeders\Auth\AdminSeeder;
use Database\Seeders\Auth\PermissionSeeder;
use Database\Seeders\References\EducationalInstitutionSeeder;
use Database\Seeders\References\EducationalLevelSeeder;
use Database\Seeders\References\RegistrationScheduleSeeder;
use Database\Seeders\References\SchoolYearSeeder;
use Database\Seeders\Setting\EmailConfigSeeder;
use Database\Seeders\Setting\MenuSeeder;
use Database\Seeders\Setting\MessageTemplateSeeder;
use Database\Seeders\Setting\WhatsappConfigSeeder;
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
            ApplicationSeeder::class,
            MenuSeeder::class,
            EducationalLevelSeeder::class,
            EducationalInstitutionSeeder::class,
            AdminSeeder::class,
            WhatsappConfigSeeder::class,
            EmailConfigSeeder::class,
            MessageTemplateSeeder::class,
            SchoolYearSeeder::class,
            RegistrationScheduleSeeder::class
        ]);
    }
}
