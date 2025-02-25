<?php

namespace App\Repositories;

use App\Models\RegistrationFee;
use App\Models\User;

class RegistrationFeeRepository
{
    protected RegistrationFee $registrationFee;

    public function __construct(RegistrationFee $registrationFee)
    {
        $this->registrationFee = $registrationFee;
    }

    public function getActiveRegistrationFee(User $user): bool
    {
        $user->load('student');

        return $this->registrationFee->educationalInstitutionId(optional($user->student)->educational_institution_id)
            ->schoolYearId(optional($user->student)->school_year_id)
            ->registrationStatus('siswa_belum_diterima')
            ->active()
            ->exists();
    }
}
