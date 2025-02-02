<?php

namespace App\Rules\Student;

use Closure;

class ValidationRule extends StudentRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->failIfNotFound($fail);
        $student = $this->getStudent();

        if ($student) {
            if ($student->registration_status == 'diterima') $fail('Tidak bisa mengubah status jika Siswa telah dinyatakan DITERIMA.');
        }
    }
}
