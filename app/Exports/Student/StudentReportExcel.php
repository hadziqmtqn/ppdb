<?php

namespace App\Exports\Student;

use App\Exports\TextValueBinder;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class StudentReportExcel implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
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
            'residence.distanceToSchool:id,name',
            'residence.transportation:id,name',
            'previousSchool.previousSchoolReference',
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
                    optional($user->residence)->province, // 'Provinsi',
                    optional($user->residence)->city, // 'Kota/Kab.',
                    optional($user->residence)->district, // 'Kec.',
                    optional($user->residence)->village, // 'Desa/Kel.',
                    optional($user->residence)->street, // 'Jalan',
                    optional($user->residence)->postal_code, // 'Kode Pos',
                    optional(optional($user->residence)->distanceToSchool)->name, // 'Jarak ke Sekolah',
                    optional(optional($user->residence)->transportation)->name, // transportasi
                    // previous school
                    optional(optional($user->previousSchool)->previousSchoolReference)->name, // 'Nama Asal Sekolah',
                    optional(optional($user->previousSchool)->previousSchoolReference)->status, // 'Status',
                    optional(optional($user->previousSchool)->previousSchoolReference)->province, // 'Provinsi',
                    optional(optional($user->previousSchool)->previousSchoolReference)->city, // 'Kota/Kab.',
                    optional(optional($user->previousSchool)->previousSchoolReference)->district, // 'Kec.',
                    optional(optional($user->previousSchool)->previousSchoolReference)->village, // 'Desa/Kel.',
                    optional(optional($user->previousSchool)->previousSchoolReference)->street, // 'Jalan',
                ]);
            });
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        $row1 = [
            // registration
            'No',
            'Registrasi',
            ...array_fill(0, 8, ''),
            // personal data
            'Data Pribadi',
            ...array_fill(0, 6, ''),
            // family
            'Keluarga',
            ...array_fill(0, 13, ''),
            // residence
            'Tempat Tinggal',
            ...array_fill(0, 7, ''),
            // previous school
            'Asal Sekolah',
            ...array_fill(0, 6, '')
        ];

        $row2 = [
            // registration
            '',
            'No. Registrasi',
            'Nama Lengkap',
            'Lembaga',
            'Kategori',
            'Kelas',
            'Jalur Pendaftaran',
            'Jurusan',
            'NISN',
            'No. Whatsapp',
            // personal data
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Anak Ke',
            'Jumlah Saudara',
            'Hubungan Keluarga',
            'Agama',
            // family
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
            // residence
            'Provinsi',
            'Kota/Kab.',
            'Kec.',
            'Desa/Kel.',
            'Jalan',
            'Kode Pos',
            'Jarak ke Sekolah',
            'Transportasi',
            // previous school
            'Nama Asal Sekolah',
            'Status',
            'Provinsi',
            'Kota/Kab.',
            'Kec.',
            'Desa/Kel.',
            'Jalan',
        ];

        return array_merge([$row1, $row2]);
    }

    public function registerEvents(): array
    {
        Cell::setValueBinder(new TextValueBinder());

        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastColumnIndex = $sheet->getHighestColumn();
                $lastColumn = Coordinate::columnIndexFromString($lastColumnIndex);
                $lastColumnToAdd = Coordinate::stringFromColumnIndex($lastColumn );
                $totalRows = $sheet->getHighestRow();
                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $sheet->getParent()->getDefaultStyle()->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A1:' . $lastColumnToAdd . '1')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:' . $lastColumnToAdd . '1')
                    ->getFont()
                    ->setBold(true);

                // merge title
                foreach ([
                     'A1:A2', 'B1:J1', 'K1:Q1',
                     'R1:AE1', 'AF1:AM1', 'AN1:AT1'
                         ] as $range) {
                    $sheet->mergeCells($range);
                }

                // background header
                $sheet->getStyle('A1:' . $lastColumnIndex . '2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('86D293');
                // border header
                $sheet->getStyle('A1:' . $lastColumnIndex . $totalRows)->getBorders()->getAllBorders()->setBorderStyle('thin');
                // semua baris menggunakan format "text" secara default
                $sheet->getStyle('A1:' . $lastColumnIndex . $totalRows)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
            }
        ];
    }
}
