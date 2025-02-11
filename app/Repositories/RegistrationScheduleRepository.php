<?php

namespace App\Repositories;

use App\Models\RegistrationSchedule;
use App\Models\Student;

class RegistrationScheduleRepository
{
    protected RegistrationSchedule $registrationSchedule;
    protected Student $student;

    /**
     * @param RegistrationSchedule $registrationSchedule
     * @param Student $student
     */

    public function __construct(RegistrationSchedule $registrationSchedule, Student $student)
    {
        $this->registrationSchedule = $registrationSchedule;
        $this->student = $student;
    }

    public function syncQuota(RegistrationSchedule $registrationSchedule): void
    {
        $totalStudents = $this->student->where([
            'educational_institution_id' => $registrationSchedule->educational_institution_id,
            'school_year_id' => $registrationSchedule->school_year_id
        ])
            ->count();

        $registrationSchedule->remaining_quota = ($registrationSchedule->quota - $totalStudents);
        $registrationSchedule->save();
    }
}
