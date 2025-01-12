<?php

namespace App\Rules\Student\StudentRegistration;

use App\Models\Student;
use App\Models\User;
use App\Rules\Student\UserRule;
use Closure;

class NisnRule extends UserRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->failIfNotFound($fail);
        $user = $this->getUser();

        if ($user) {
            $whatsappNumberExist = Student::where('nisn', $value)
                ->where('user_id', '!=', $user->id)
                ->exists();

            if ($whatsappNumberExist) $fail('NISN telah digunakan');
        }
    }
}
