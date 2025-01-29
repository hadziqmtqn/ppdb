<?php

namespace App\Repositories\Student;

use App\Models\User;
use Illuminate\Support\Collection;

class StudentRegistrationRepository
{
    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function menus(User $user): Collection
    {
        $user->load('student', 'personalData', 'family', 'placeOfRecidence', 'previousSchool');

        return collect([
            'Pendaftaran' => collect([
                'icon' => 'mdi-account-plus-outline',
                'url' => route('student-registration.index', $user->username),
                'isCompleted' => (bool)$user->student
            ]),
            'Data Pribadi' => collect([
                'icon' => 'mdi-account-outline',
                'url' => route('personal-data.index', $user->username),
                'isCompleted' => (bool)$user->personalData
            ]),
            'Keluarga' => collect([
                'icon' => 'mdi-account-network',
                'url' => route('family.index', $user->username),
                'isCompleted' => (bool)$user->family
            ]),
            'Tempat Tinggal' => collect([
                'icon' => 'mdi-map-marker-outline',
                'url' => '#',
                'isCompleted' => (bool)$user->placeOfRecidence
            ]),
            'Asal Sekolah' => collect([
                'icon' => 'mdi-school-outline',
                'url' => '#',
                'isCompleted' => (bool)$user->previousSchool
            ])
        ]);
    }
}
