<?php

namespace App\Rules\Student;

use App\Models\Student;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

abstract class StudentRule implements ValidationRule
{
    protected mixed $username;

    public function __construct(mixed $username)
    {
        $this->username = $username;
    }

    protected function getStudent(): ?Student
    {
        return Student::whereHas('user', function ($query) {
            $query->where([
                'username' => $this->username,
                'is_active' => true
            ]);
        })
            ->first();
    }

    protected function failIfNotFound(Closure $fail): void
    {
        if (!$this->getStudent()) $fail('Data siswa tidak ditemukan/tidak aktif');
    }
}
