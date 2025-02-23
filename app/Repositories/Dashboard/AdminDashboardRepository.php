<?php

namespace App\Repositories\Dashboard;

use App\Models\EducationalInstitution;
use App\Models\Student;
use Illuminate\Support\Collection;

class AdminDashboardRepository
{
    protected EducationalInstitution $educationalInstitution;
    protected Student $student;

    public function __construct(EducationalInstitution $educationalInstitution, Student $student)
    {
        $this->educationalInstitution = $educationalInstitution;
        $this->student = $student;
    }

    public function totalBaseData(): Collection
    {
        return collect([
            'Total Lembaga' => [
                'title' => null,
                'icon' => 'office-building-marker-outline',
                'color' => 'primary',
                'total' => $this->educationalInstitution->active()->count()
            ],
            'Total Semua Siswa' => [
                'title' => 'Jumlah siswa terdaftar dalam aplikasi',
                'icon' => 'account-group-outline',
                'color' => 'success',
                'total' => $this->student->count()
            ]
        ]);
    }
}
