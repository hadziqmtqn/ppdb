<?php

namespace Database\Seeders\References;

use App\Models\EducationalInstitution;
use App\Models\RegistrationSchedule;
use App\Models\SchoolYear;
use Illuminate\Database\Seeder;

class RegistrationScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $educationalInstitutions = EducationalInstitution::get();
        $schoolYearActive = SchoolYear::query()
            ->active()
            ->firstOrFail();

        foreach ($educationalInstitutions as $educationalInstitution) {
            $registrationSchedule = new RegistrationSchedule();
            $registrationSchedule->educational_institution_id = $educationalInstitution->id;
            $registrationSchedule->school_year_id = $schoolYearActive->id;
            $registrationSchedule->start_date = '2025-01-01';
            $registrationSchedule->end_date = '2025-04-10';
            $registrationSchedule->quota = 100;
            $registrationSchedule->save();
        }
    }
}
