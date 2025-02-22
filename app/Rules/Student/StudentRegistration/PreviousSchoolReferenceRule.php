<?php

namespace App\Rules\Student\StudentRegistration;

use App\Rules\Student\UserRule;
use Closure;

class PreviousSchoolReferenceRule extends UserRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->failIfNotFound($fail);
        $user = $this->getUser();

        if ($user) {
            if (($user->school_reports_count > 0) && (optional($user->previousSchool)->previous_school_reference_id != $value)) {
                $fail('Tidak boleh mengubah Asal Sekolah jika sudah mengisi Nilai Rapor');
            }
        }
    }
}
