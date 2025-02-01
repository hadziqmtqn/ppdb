<?php

namespace App\Repositories\Student;

use App\Models\User;
use Illuminate\Support\Collection;

class StudentRepository
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function registration(User $user): Collection
    {
        return collect([
            'Lembaga' => optional(optional($user->student)->educationalInstitution)->name,
            'No. Registrasi' => optional($user->student)->registration_number,
            'Kategori' => optional(optional($user->student)->registrationCategory)->name,
            'Jalur Pendaftaran' => optional(optional($user->student)->registrationPath)->name,
            'Kelas' => optional(optional($user->student)->classLevel)->name,
            'NISN' => optional($user->student)->nisn,
            'No. Whatsapp' => optional($user->student)->whatsapp_number,
        ]);
    }
}
