<?php

namespace Database\Seeders\Student;

use App\Models\DetailSchoolReport;
use App\Models\EducationalGroup;
use App\Models\LessonMapping;
use App\Models\PersonalData;
use App\Models\PreviousSchool;
use App\Models\PreviousSchoolReference;
use App\Models\RegistrationSetting;
use App\Models\SchoolReport;
use App\Models\Student;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        Student::factory(100)
            ->create()
            ->each(function (Student $student) use ($faker) {
                // Personal Data
                $personalData = new PersonalData();
                $personalData->user_id = $student->user_id;
                $personalData->place_of_birth = $faker->city;
                $personalData->date_of_birth = $student->educational_institution_id == 1 ? 2018 . '-' . date('m-d') : 2010 . '-' . date('m-d');
                $personalData->gender = $faker->randomElement(['Laki-laki','Perempuan']);
                $personalData->child_to = 2;
                $personalData->number_of_brothers = 2;
                $personalData->family_relationship = 'Anak Kandung';
                $personalData->religion = 'Islam';
                $personalData->save();

                // Previous School
                $educationalGroups = EducationalGroup::where('next_educational_level_id', $student->educationalInstitution->educational_level_id)
                    ->pluck('id')
                    ->random();
                $previousSchoolReferences = PreviousSchoolReference::educationalGroupId($educationalGroups)
                    ->pluck('id')
                    ->random();

                $previousSchool = new PreviousSchool();
                $previousSchool->user_id = $student->user_id;
                $previousSchool->previous_school_reference_id = $previousSchoolReferences;
                $previousSchool->save();

                // School Report
                $registrationSetting = RegistrationSetting::educationalInstitutionId($student->educational_institution_id)
                    ->acceptedWithSchoolReport()
                    ->first();

                $lessonMappings = LessonMapping::educationalInstitutionId($student->educational_institution_id)
                    ->whereHas('lesson', fn($query) => $query->where('is_active', true))
                    ->get()
                    ->filter(function (LessonMapping $lessonMapping) use ($student) {
                        $previousEducationalGroups = collect(json_decode($lessonMapping->previous_educational_group, true));
                        return $previousEducationalGroups->contains(optional(optional(optional($student->user)->previousSchool)->previousSchoolReference)->educational_group_id);
                    });

                if ($registrationSetting) {
                    $semesters = json_decode($registrationSetting->school_report_semester, true);

                    foreach ($semesters as $semester) {
                        $schoolReport = new SchoolReport();
                        $schoolReport->user_id = $student->user_id;
                        $schoolReport->semester = $semester;
                        $schoolReport->save();

                        $lessonMappings->map(function (LessonMapping $lessonMapping) use ($schoolReport, $faker) {
                            $detailSchoolReport = new DetailSchoolReport();
                            $detailSchoolReport->school_report_id = $schoolReport->id;
                            $detailSchoolReport->lesson_id = $lessonMapping->lesson_id;
                            $detailSchoolReport->score = $faker->randomFloat(0,75,100);
                            $detailSchoolReport->save();
                        });

                        $totalGeneralLesson = DetailSchoolReport::whereHas('lesson', fn($query) => $query->where('type', 'umum'))
                            ->schoolReportId($schoolReport->id)
                            ->sum('score');

                        $avgScoreReligiousStudy = DetailSchoolReport::whereHas('lesson', fn($query) => $query->where('type', 'keagamaan'))
                            ->schoolReportId($schoolReport->id)
                            ->avg('score');

                        $schoolReport->total_score = $totalGeneralLesson + $avgScoreReligiousStudy;
                        $schoolReport->save();
                    }
                }
            });
    }
}
