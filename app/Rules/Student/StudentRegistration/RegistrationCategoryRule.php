<?php

namespace App\Rules\Student\StudentRegistration;

use App\Rules\Student\UserRule;
use Closure;

class RegistrationCategoryRule extends UserRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->failIfNotFound($fail);
        $student = $this->getUser();

        if (optional(optional($student)->student)->registration_category_id != $value) {
            $fail('Kategori pendaftaran tidak bisa diubah');
        }
    }
}
