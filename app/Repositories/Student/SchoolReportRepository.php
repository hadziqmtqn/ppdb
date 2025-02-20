<?php

namespace App\Repositories\Student;

use App\Models\DetailSchoolReport;
use App\Models\LessonMapping;
use App\Models\RegistrationSetting;
use App\Models\User;
use Illuminate\Support\Collection;

class SchoolReportRepository
{
    protected RegistrationSetting $registrationSetting;
    protected LessonMapping $lessonMapping;
    protected DetailSchoolReport $detailSchoolReport;

    public function __construct(RegistrationSetting $registrationSetting, LessonMapping $lessonMapping, DetailSchoolReport $detailSchoolReport)
    {
        $this->registrationSetting = $registrationSetting;
        $this->lessonMapping = $lessonMapping;
        $this->detailSchoolReport = $detailSchoolReport;
    }

    public function getLessons(User $user): Collection
    {
        $registrationSetting = $this->registrationSetting->educationalInstitutionId($user->student->educational_institution_id)
            ->acceptedWithSchoolReport()
            ->first();

        if (!$registrationSetting) return collect();

        $semesters = collect(json_decode($registrationSetting->school_report_semester, true));
        $lessonMappings = $this->lessonMapping->educationalInstitutionId(optional($user->student)->educational_institution_id)
            ->whereHas('lesson', fn($query) => $query->where('is_active', true))
            ->get()
            ->filter(function (LessonMapping $lessonMapping) use ($user) {
                $previousEducationalGroups = collect(json_decode($lessonMapping->previous_educational_group, true));
                return $previousEducationalGroups->contains(optional($user->previousSchool)->educational_group_id);
            });

        return $semesters->mapWithKeys(function ($semester) use ($lessonMappings, $user) {
            return [
                $semester => collect([
                    'totalScore' => 0,
                    'detailSchoolReports' => $lessonMappings->map(function (LessonMapping $lessonMapping) use ($user, $semester) {
                        $score = $this->detailSchoolReport->whereHas('schoolReport', function ($query) use ($user, $semester) {
                            $query->where([
                                'user_id' =>$user->id,
                                'semester' => $semester
                            ]);
                        })
                            ->lessonId($lessonMapping->lesson_id)
                            ->first();

                        return [
                            'lessonId' => $lessonMapping->lesson_id,
                            'lessonName' => optional($lessonMapping->lesson)->name,
                            'score' => $score?->score
                        ];
                    })
                ])
            ];
        });
    }
}
