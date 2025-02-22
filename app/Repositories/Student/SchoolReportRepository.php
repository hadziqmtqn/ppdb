<?php

namespace App\Repositories\Student;

use App\Models\DetailSchoolReport;
use App\Models\LessonMapping;
use App\Models\RegistrationSetting;
use App\Models\SchoolReport;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class SchoolReportRepository
{
    protected RegistrationSetting $registrationSetting;
    protected LessonMapping $lessonMapping;
    protected DetailSchoolReport $detailSchoolReport;
    protected SchoolReport $schoolReport;

    public function __construct(RegistrationSetting $registrationSetting, LessonMapping $lessonMapping, DetailSchoolReport $detailSchoolReport, SchoolReport $schoolReport)
    {
        $this->registrationSetting = $registrationSetting;
        $this->lessonMapping = $lessonMapping;
        $this->detailSchoolReport = $detailSchoolReport;
        $this->schoolReport = $schoolReport;
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
                return $previousEducationalGroups->contains(optional(optional($user->previousSchool)->previousSchoolReference)->educational_group_id);
            });

        return $semesters->mapWithKeys(function ($semester) use ($lessonMappings, $user) {
            $schoolReport = $this->schoolReport->filterData([
                'user_id' => $user->id,
                'semester' => $semester
            ])
                ->first();

            return [
                $semester => collect([
                    'slug' => $schoolReport?->slug,
                    'totalScore' => $schoolReport?->total_score,
                    'file' => $schoolReport && $schoolReport->hasMedia('rapor_semester_' . $semester) ? $schoolReport->getFirstTemporaryUrl(Carbon::now()->addHour(), 'rapor_semester_' . $semester) : null,
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

    public function getByUser(User $user): Collection
    {
        $user->load('schoolReports.detailSchoolReports.lesson:id,name');

        return collect([
            'totalScore' => $user->schoolReports->sum('total_score'),
            'schoolReports' => $user->schoolReports->map(function (SchoolReport $schoolReport) {
                return collect([
                    'semester' => $schoolReport->semester,
                    'totalScore' => $schoolReport->total_score,
                    'detailSchoolReports' => $schoolReport->detailSchoolReports->map(function (DetailSchoolReport $detailSchoolReport) {
                        return collect([
                            'lessonName' => optional($detailSchoolReport->lesson)->name,
                            'score' => $detailSchoolReport->score
                        ]);
                    })
                ]);
            })
        ]);
    }

    public function isComplete(User $user): bool
    {
        $lessons = $this->getLessons($user);

        foreach ($lessons as $data) {
            if (is_null($data['file'])) {
                return false;
            }

            foreach ($data['detailSchoolReports'] as $detail) {
                if (is_null($detail['score'])) {
                    return false;
                }
            }
        }

        return true;
    }
}
