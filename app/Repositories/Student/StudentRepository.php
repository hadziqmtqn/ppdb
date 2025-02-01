<?php

namespace App\Repositories\Student;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class StudentRepository
{
    // TODO Registration
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

    // TODO Personal Data
    public function personalData(User $user): Collection
    {
        return collect([
            'Nama Lengkap' => $user->name,
            'Tempat Lahir' => optional($user->personalData)->place_of_birth,
            'Tanggal Lahir' => $user->personalData ? Carbon::parse(optional($user->personalData)->date_of_birth)->isoFormat('DD MMMM Y') : null,
            'Jenis Kelamin' => optional($user->personalData)->gender,
            'Hubungan Keluarga' => optional($user->personalData)->family_relationship,
            'Agama' => optional($user->personalData)->religion,
        ]);
    }

    // TODO Family
    public function family(User $user): Collection
    {
        return collect([
            'NIK' => optional($user->family)->national_identification_number,
            'No. KK' => optional($user->family)->family_card_number,
            'Nama Ayah Kandung' => optional($user->family)->father_name,
            '- Pendidikan Ayah' => optional(optional($user->family)->fatherEducation)->name,
            '- Pekerjaan Ayah' => optional(optional($user->family)->fatherProfession)->name,
            '- Penghasilan Ayah' => optional(optional($user->family)->fatherIncome)->nominal,
            'Nama Ibu Kandung' => optional($user->family)->mother_name,
            '- Pendidikan Ibu' => optional(optional($user->family)->motherEducation)->name,
            '- Pekerjaan Ibu' => optional(optional($user->family)->motherProfession)->name,
            '- Penghasilan Ibu' => optional(optional($user->family)->motherIncome)->nominal,
            'Nama Wali' => optional($user->family)->guardian_name,
            '- Pendidikan Wali' => optional(optional($user->family)->guardianEducation)->name,
            '- Pekerjaan Wali' => optional(optional($user->family)->guardianProfession)->name,
            '- Penghasilan Wali' => optional(optional($user->family)->guardianIncome)->nominal,
        ]);
    }

    // TODO Residence
    public function resicende(User $user): Collection
    {
        return collect([
            'Provinsi' => optional($user->residence)->province,
            'Kota/Kab.' => optional($user->residence)->city,
            'Kecamatan' => optional($user->residence)->district,
            'Desa/Kel.' => optional($user->residence)->village,
            'Jalan' => optional($user->residence)->street,
            'Kode Pos' => optional($user->residence)->postal_code,
            'Jarak Ke Sekolah' => optional(optional($user->residence)->distanceToSchool)->name,
            'Transportasi' => optional(optional($user->residence)->transportation)->name,
        ]);
    }
    // TODO Previous School
    public function previousSchool(User $user): Collection
    {
        return collect([
            'Nama Asal Sekolah' => optional($user->previousSchool)->school_name,
            'Status' => optional($user->previousSchool)->status,
            'Provinsi' => optional($user->previousSchool)->province,
            'Kota/Kab.' => optional($user->previousSchool)->city,
            'Kecamatan' => optional($user->previousSchool)->district,
            'Desa/Kel.' => optional($user->previousSchool)->village,
            'Jalan' => optional($user->previousSchool)->street,
        ]);
    }
}
