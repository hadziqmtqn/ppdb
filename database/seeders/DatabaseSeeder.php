<?php

namespace Database\Seeders;

use App\Models\Student;
use Database\Seeders\Auth\AdminSeeder;
use Database\Seeders\Auth\PermissionSeeder;
use Database\Seeders\Payment\BankAccountSeeder;
use Database\Seeders\Payment\PaymentChannelSeeder;
use Database\Seeders\Payment\PaymentSettingSeeder;
use Database\Seeders\Payment\RegistrationFeeSeeder;
use Database\Seeders\References\ClassLevelSeeder;
use Database\Seeders\References\DistanceToSchoolSeeder;
use Database\Seeders\References\EducationalInstitutionSeeder;
use Database\Seeders\References\EducationalLevelSeeder;
use Database\Seeders\References\EducationSeeder;
use Database\Seeders\References\MediaFileSeeder;
use Database\Seeders\References\IncomeSeeder;
use Database\Seeders\References\MajorSeeder;
use Database\Seeders\References\ProfessionSeeder;
use Database\Seeders\References\RegistrationCategorySeeder;
use Database\Seeders\References\RegistrationPathSeeder;
use Database\Seeders\References\RegistrationScheduleSeeder;
use Database\Seeders\References\SchoolYearSeeder;
use Database\Seeders\References\TransportationSeeder;
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
            RegistrationScheduleSeeder::class,
            RegistrationCategorySeeder::class,
            ClassLevelSeeder::class,
            RegistrationPathSeeder::class,
            MajorSeeder::class,
            DistanceToSchoolSeeder::class,
            TransportationSeeder::class,
            ProfessionSeeder::class,
            EducationSeeder::class,
            IncomeSeeder::class,
            MediaFileSeeder::class,
            // TODO Payment
            PaymentSettingSeeder::class,
            PaymentChannelSeeder::class,
            BankAccountSeeder::class,
            RegistrationFeeSeeder::class
        ]);

        Student::factory()
            ->count(100)
            ->create();
    }
}
