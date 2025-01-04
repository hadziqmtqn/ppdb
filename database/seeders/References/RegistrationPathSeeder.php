<?php

namespace Database\Seeders\References;

use App\Models\EducationalInstitution;
use App\Models\RegistrationPath;
use Illuminate\Database\Seeder;

class RegistrationPathSeeder extends Seeder
{
    public function run(): void
    {
        $educationalInstitutions = EducationalInstitution::get();
        foreach ($educationalInstitutions as $educationalInstitution) {
            foreach (['Regular', 'Prestasi'] as $item) {
                $registrationPath = new RegistrationPath();
                $registrationPath->educational_institution_id = $educationalInstitution->id;
                $registrationPath->name = $item;
                $registrationPath->save();
            }
        }
    }
}
