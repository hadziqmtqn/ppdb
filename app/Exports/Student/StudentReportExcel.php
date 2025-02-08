<?php

namespace App\Exports\Student;

use App\Models\User;
use Illuminate\Support\Carbon;
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
            'family.fatherEducation:id,name',
            'family.fatherProfession:id,name',
            'family.fatherIncome:id,nominal',
            'family.motherEducation:id,name',
            'family.motherProfession:id,name',
            'family.motherIncome:id,nominal',
            'family.guardianEducation:id,name',
            'family.guardianProfession:id,name',
            'family.guardianIncome:id,nominal',
            'residence',
            'previousSchool',
        ])
            ->filterStudentDatatable($this->request)
            ->orderBy('name')
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
                    optional(optional($user->student)->major)->name, // jurusan
                    optional($user->student)->nisn, // nisn
                    optional($user->student)->whatsapp_number, // 'No. Whatsapp',
                    optional($user->personalData)->place_of_birth, //'Tempat Lahir',
                    optional($user->personalData)->date_of_birth ? Carbon::parse($user->personalData->date_of_birth)->isoFormat('DD MMMM Y') : null, // 'Tanggal Lahir',
                    optional($user->personalData)->gender, // 'Jenis Kelamin',
                    optional($user->personalData)->child_to, // 'Anak Ke',
                    optional($user->personalData)->number_of_brothers, // 'Jumlah Saudara'
                    optional($user->personalData)->family_relationship, // 'Hubungan Keluarga',
                    optional($user->personalData)->religion, // 'Agama',
                    optional($user->family)->national_identification_number, // 'NIK',
                    optional($user->family)->family_card_number, // 'No. KK',
                    optional($user->family)->father_name, // 'Nama Ayah Kandung',
                    optional(optional($user->family)->fatherEducation)->name, // 'Pendidikan Ayah',
                    optional(optional($user->family)->fatherProfession)->name, // 'Pekerjaan Ayah',
                    optional(optional($user->family)->fatherIncome)->nominal, // 'Penghasilan Ayah',
                    optional($user->family)->mother_name, // 'Nama Ibu Kandung',
                    optional(optional($user->family)->motherEducation)->name, // 'Pendidikan Ibu',
                    optional(optional($user->family)->motherProfession)->name, // 'Pekerjaan Ibu',
                    optional(optional($user->family)->motherIncome)->nominal, // 'Penghasilan Ibu',
                    optional($user->family)->guardian_name, // 'Nama Wali Kandung',
                    optional(optional($user->family)->guardianEducation)->name, // 'Pendidikan Wali',
                    optional(optional($user->family)->guardianProfession)->name, // 'Pekerjaan Wali',
                    optional(optional($user->family)->guardianIncome)->nominal, // 'Penghasilan Wali',
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
            'Jumlah Saudara',
            'Hubungan Keluarga',
            'Agama',
            'NIK',
            'No. KK',
            'Nama Ayah Kandung',
            'Pendidikan Ayah',
            'Pekerjaan Ayah',
            'Penghasilan Ayah',
            'Nama Ibu Kandung',
            'Pendidikan Ibu',
            'Pekerjaan Ibu',
            'Penghasilan Ibu',
            'Nama Wali Kandung',
            'Pendidikan Wali',
            'Pekerjaan Wali',
            'Penghasilan Wali',
        ];
    }
}
