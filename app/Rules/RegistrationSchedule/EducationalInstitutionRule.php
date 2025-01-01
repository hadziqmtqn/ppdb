<?php

namespace App\Rules\RegistrationSchedule;

use App\Models\RegistrationSchedule;
use Closure;

class EducationalInstitutionRule extends ScheduleRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->failIfNotFound($fail);

        if ($this->getEducationalInstitution() && $this->getSchoolYear()) {
            $registrationScheduleExist = RegistrationSchedule::query()
                ->filterData([
                    'educational_institution_id' => $this->getEducationalInstitution()->id,
                    'school_year_id' => $this->getSchoolYear()->id
                ])
                ->exists();

            if ($registrationScheduleExist) $fail('Jadwal pendaftaran ' . $this->getEducationalInstitution()->name . ' telah dibuat');
        }
    }
}
