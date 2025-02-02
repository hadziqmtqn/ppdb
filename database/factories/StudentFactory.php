<?php

namespace Database\Factories;

use App\Models\ClassLevel;
use App\Models\EducationalInstitution;
use App\Models\Major;
use App\Models\RegistrationCategory;
use App\Models\RegistrationPath;
use App\Models\SchoolYear;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        $educationalInstitution = EducationalInstitution::pluck('id');
        $registrationCategory = RegistrationCategory::pluck('id');
        $registrationPath = RegistrationPath::pluck('id');

        $selectedInstitution = $educationalInstitution->random();
        $selectedCategory = $registrationCategory->random();

        $major = Major::educationalInstitutionId($selectedInstitution)
            ->pluck('id');
        $classLevel = ClassLevel::educationalInstitutionId($selectedInstitution)
            ->registrationCategoryId($selectedCategory)
            ->pluck('id');

        return [
            'whatsapp_number' => $this->faker->regexify('08[2-9]{10}'),
            'nisn' => $this->faker->numerify('##########'),
            'registration_status' => $this->faker->randomElement(['belum_diterima', 'diterima']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'school_year_id' => SchoolYear::active()->first()->id,
            'educational_institution_id' => $selectedInstitution,
            'registration_category_id' => $selectedCategory,
            'registration_path_id' => $registrationPath->random(),
            'major_id' => $major->isNotEmpty() ? $major->random() : null,
            'class_level_id' => $classLevel->random()
        ];
    }
}
