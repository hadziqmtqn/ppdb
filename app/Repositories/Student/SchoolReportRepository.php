<?php

namespace App\Repositories\Student;

use App\Models\LessonMapping;
use App\Models\RegistrationSetting;
use App\Models\User;
use Illuminate\Support\Collection;

class SchoolReportRepository
{
    protected RegistrationSetting $registrationSetting;
    protected LessonMapping $lessonMapping;

    public function __construct(RegistrationSetting $registrationSetting, LessonMapping $lessonMapping)
    {
        $this->registrationSetting = $registrationSetting;
        $this->lessonMapping = $lessonMapping;
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

        return $semesters->mapWithKeys(function ($semester) use ($lessonMappings) {
            return [
                $semester => $lessonMappings->map(function (LessonMapping $lessonMapping) {
                    return [
                        'id' => $lessonMapping->id,
                        'lessonName' => optional($lessonMapping->lesson)->name
                    ];
                })
            ];
        });
    }
}
