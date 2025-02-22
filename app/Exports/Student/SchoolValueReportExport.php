<?php

namespace App\Exports\Student;

use App\Models\EducationalGroup;
use App\Models\EducationalInstitution;
use App\Models\LessonMapping;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SchoolValueReportExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    use Exportable;

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function educationalInstitution(): ?EducationalInstitution
    {
        return EducationalInstitution::with('registrationSetting')
            ->find($this->request->input('educational_institution_id'));
    }

    private function educationalGroup(): ?EducationalGroup
    {
        return EducationalGroup::find($this->request->input('educational_group_id'));
    }

    public function collection(): Collection
    {
        $lessons = $this->getLessons();

        $users = User::with('student.educationalInstitution', 'previousSchool', 'schoolReports.detailSchoolReports')
            ->withSum('schoolReports', 'total_score')
            ->whereHas('student', fn($query) => $query->where('educational_institution_id', $this->educationalInstitution()->id))
            ->whereHas('previousSchool', fn($query) => $query->where('educational_group_id', $this->educationalGroup()->id))
            ->whereHas('schoolReports')
            ->get()
            ->sortByDesc('school_reports_sum_total_score');

        return $users->map(function (User $user) use ($lessons) {
            static $no = 0;
            $no++;

            $row = collect([
                $no,
                $user->name,
                optional($user->student)->registration_number,
                optional(optional($user->student)->educationalInstitution)->name,
                optional($user->previousSchool)->school_name
            ]);

            foreach ($lessons as $lesson) {
                foreach ($lesson['semesters'] as $semester) {
                    $score = $user->schoolReports
                        ->where('semester', $semester)
                        ->flatMap(fn($report) => $report->detailSchoolReports)
                        ->where('lesson_id', $lesson['lessonId'])
                        ->first()
                        ->score ?? '';
                    $row->push($score);
                }
            }

            $row->push($user->schoolReports->sum('total_score'));

            return $row;
        });
    }

    public function headings(): array
    {
        $mainHeading = [
            'No',
            'Nama',
            'No. Registrasi',
            'Lembaga',
            'Asal Sekolah'
        ];

        $semesterHeading = array_fill(0, 5, ''); // baris kosong dibawah mainHeading

        $lessons = $this->getLessons();
        foreach ($lessons as $lesson) {
            $mainHeading[] = $lesson['lessonCode'];
            $semesterCount = count($lesson['semesters']);
            for ($i = 1; $i < $semesterCount; $i++) {
                $mainHeading[] = '';
            }
            foreach ($lesson['semesters'] as $semester) {
                $semesterHeading[] = 'Sem. ' . $semester;
            }
        }

        $mainHeading[] = 'Skor';
        $semesterHeading[] = '';

        return [$mainHeading, $semesterHeading];
    }

    private function getLessons(): Collection
    {
        $registrationSetting = $this->educationalInstitution()->registrationSetting;

        $semesters = $registrationSetting->accepted_with_school_report
            ? collect(json_decode($registrationSetting->school_report_semester, true))
            : collect();

        return LessonMapping::educationalInstitutionId($this->educationalInstitution()->id)
            ->whereHas('lesson', fn($query) => $query->where('is_active', true))
            ->get()
            ->filter(fn($lessonMapping) => collect(json_decode($lessonMapping->previous_educational_group, true))
                ->contains($this->educationalGroup()->id))
            ->map(fn($lessonMapping) => [
                'lessonId' => $lessonMapping->lesson_id,
                'lessonCode' => optional($lessonMapping->lesson)->code,
                'semesters' => $semesters
            ]);
    }

    public function registerEvents(): array
    {
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

                $sheet->getStyle('A1:' . $lastColumnToAdd . '2')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:' . $lastColumnToAdd . '2')
                    ->getFont()
                    ->setBold(true);

                // merge title
                foreach (['A1:A2','B1:B2','C1:C2','D1:D2','E1:E2'] as $range) {
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