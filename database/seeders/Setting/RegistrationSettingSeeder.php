<?php

namespace Database\Seeders\Setting;

use App\Models\EducationalInstitution;
use App\Models\RegistrationSetting;
use Illuminate\Database\Seeder;

class RegistrationSettingSeeder extends Seeder
{
    public function run(): void
    {
        $educationalInstitutions = EducationalInstitution::get();

        foreach ($educationalInstitutions as $educationalInstitution) {
            $registrationSetting = new RegistrationSetting();
            $registrationSetting->educational_institution_id = $educationalInstitution->id;
            $registrationSetting->accepted_with_school_report = !($educationalInstitution->educational_level_id == 1);
            $registrationSetting->save();
        }
    }
}
