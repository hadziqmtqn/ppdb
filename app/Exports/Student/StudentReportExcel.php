<?php

namespace App\Exports\Student;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentReportExcel implements FromCollection, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected mixed $request;

    /**
     * @param mixed $request
     */
    public function __construct(mixed $request)
    {
        $this->request = $request;
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return User::with([
            'student.educationalInstitution',
            'student.classLevel',
            'student.major',
            'student.registrationCategory',
            'student.registrationPath',
            'student.schoolYear',
            'personalData',
            'family',
            'residence',
            'previousSchool'
        ])
            ->filterStudentDatatable($this->request)
            ->get()
            ->map(function (User $user) {
                static $no = 0;
                $no++;

                return collect([
                    $no, // no
                    optional($user->student)->registration_number, // no registrasi
                    $user->name, // nama lengkap
                    optional(optional($user->student)->educationalInstitution)->name, // lembaga
                    optional(optional($user->student)->registrationCategory)->name, // kategori
                    optional(optional($user->student)->classLevel)->name, // kelas
                    optional(optional($user->student)->registrationPath)->name, // jalur pendaftaran
                ]);
            });
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'No',
            'No. Registrasi',
            'Nama Lengkap',
            'Lembaga',
            'Kategori',
            'Kelas',
            'Jalur Pendaftaran',
            'Jurusan',
            'NISN',
            'No. Whatsapp',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Anak Ke',
            'Jumlah Saudara'
        ];
    }
}
