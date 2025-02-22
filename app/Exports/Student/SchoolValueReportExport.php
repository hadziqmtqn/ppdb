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
use Maatwebsite\Excel\Concerns\WithHeadings;

class SchoolValueReportExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected Request $request;

    /**
     * @param Request $request
     */
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

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        // Implement the logic for gathering the data collection here.
        return User::with('student.educationalInstitution', 'previousSchool')
            ->whereHas('student', fn($query) => $query->where('educational_institution_id', $this->educationalInstitution()->id))
            ->whereHas('previousSchool', fn($query) => $query->where('educational_group_id', $this->educationalGroup()->id))
            ->whereHas('schoolReports')
            ->get()
            ->map(function (User $user, $index) {
                return collect([
                    $index + 1,
                    $user->name,
                    optional(optional($user->student)->educationalInstitution)->name,
                    optional($user->previousSchool)->school_name
                ]);
            });
    }

    public function headings(): array
    {
        $mainHeading = [
            'No',
            'Nama',
            'Lembaga',
            'Asal Sekolah'
        ];

        $semesterHeading = [...array_fill(0, 4, '')]; // baris kosong dibawah mainHeading

        $lessons = $this->getLessons();
        foreach ($lessons as $lesson) {
            $mainHeading[] = $lesson['lessonCode'];
            $semesterCount = count($lesson['semesters']);
            for ($i = 1; $i < $semesterCount; $i++) {
                $mainHeading[] = '';
            }
            foreach ($lesson['semesters'] as $semester) {
                $semesterHeading[] = $semester;
            }
        }

        return [$mainHeading, $semesterHeading, ['Skor']];
    }

    private function getLessons(): Collection
    {
        return LessonMapping::educationalInstitutionId($this->educationalInstitution()->id)
            ->whereHas('lesson', fn($query) => $query->where('is_active', true))
            ->get()
            ->filter(function (LessonMapping $lessonMapping) {
                $previousEducationalGroups = collect(json_decode($lessonMapping->previous_educational_group, true));
                return $previousEducationalGroups->contains($this->educationalGroup()->id);
            })
            ->map(function (LessonMapping $lessonMapping) {
                return [
                    'lessonId' => $lessonMapping->lesson_id,
                    'lessonCode' => optional($lessonMapping->lesson)->code,
                    'semesters' => $this->semesters()
                ];
            });
    }

    private function semesters(): Collection
    {
        $registrationSetting = $this->educationalInstitution()->registrationSetting;

        if ($registrationSetting->accepted_with_school_report) {
            $semesters = collect(json_decode($registrationSetting->school_report_semester, true));
        } else {
            $semesters = collect();
        }

        return $semesters;
    }
}