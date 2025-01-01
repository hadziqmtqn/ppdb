<?php

namespace App\Rules\RegistrationSchedule;

use App\Models\EducationalInstitution;
use App\Models\SchoolYear;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

abstract class ScheduleRule implements ValidationRule
{
    protected mixed $educationalInstitutionId;
    protected mixed $schoolYearId;

    public function __construct($educationalInstitutionId, $schoolYearId)
    {
        $this->educationalInstitutionId = $educationalInstitutionId;
        $this->schoolYearId = $schoolYearId;
    }

    protected function getEducationalInstitution(): ?EducationalInstitution
    {
        return EducationalInstitution::find($this->educationalInstitutionId);
    }

    protected function getSchoolYear(): SchoolYear
    {
        return SchoolYear::find($this->schoolYearId);
    }

    protected function failIfNotFound(Closure $fail): void
    {
        if (!$this->getEducationalInstitution()) $fail('Lembaga pendidikan tidak ditemukan');
        if (!$this->getSchoolYear()) $fail('Tahun ajaran tidak ditemukan');
    }
}
