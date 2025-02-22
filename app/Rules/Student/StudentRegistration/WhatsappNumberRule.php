<?php

namespace App\Rules\Student\StudentRegistration;

use App\Models\Student;
use App\Models\User;
use App\Rules\Student\UserRule;
use Closure;

class WhatsappNumberRule extends UserRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->failIfNotFound($fail);
        $user = $this->getUser();

        if ($user) {
            $whatsappNumberExist = Student::where('whatsapp_number', $value)
                ->where('user_id', '!=', $user->id)
                ->exists();

            if ($whatsappNumberExist) $fail('No. Whatsapp telah digunakan');
        }
    }
}
