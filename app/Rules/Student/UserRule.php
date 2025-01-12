<?php

namespace App\Rules\Student;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

abstract class UserRule implements ValidationRule
{
    protected mixed $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    protected function getUser(): ?User
    {
        return User::with('student')
            ->filterByUsername($this->username)
            ->first();
    }

    protected function failIfNotFound(Closure $fail): void
    {
        if (!$this->getUser()) $fail('Data Siswa tidak ditemukan');
    }
}
