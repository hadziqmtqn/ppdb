<?php

namespace Database\Seeders\References;

use App\Models\ClassLevel;
use App\Models\EducationalInstitution;
use Illuminate\Database\Seeder;

class ClassLevelSeeder extends Seeder
{
    public function run(): void
    {
        $educationalInstitutions = EducationalInstitution::with('educationalLevel:id,code')
            ->get();

        foreach ($educationalInstitutions as $educationalInstitution) {
            if (optional($educationalInstitution->educationalLevel)->code == 'SD') {
                foreach (range(1,6) as $class) {
                    $classLevel = new ClassLevel();
                    $classLevel->educational_institution_id = $educationalInstitution->id;
                    $classLevel->registration_category_id = $class == 1 ? 1 : 2; // 1 Baru, 2 Pindahan
                    $classLevel->name = 'Kelas ' . $class;
                    $classLevel->save();
                }
            }

            if (optional($educationalInstitution->educationalLevel)->code == 'SMP') {
                foreach (range(7,9) as $class) {
                    $classLevel = new ClassLevel();
                    $classLevel->educational_institution_id = $educationalInstitution->id;
                    $classLevel->registration_category_id = $class == 7 ? 1 : 2; // 1 Baru, 2 Pindahan
                    $classLevel->name = 'Kelas ' . $class;
                    $classLevel->save();
                }
            }

            if (optional($educationalInstitution->educationalLevel)->code == 'SMA') {
                foreach (range(10,12) as $class) {
                    $classLevel = new ClassLevel();
                    $classLevel->educational_institution_id = $educationalInstitution->id;
                    $classLevel->registration_category_id = $class == 10 ? 1 : 2; // 1 Baru, 2 Pindahan
                    $classLevel->name = 'Kelas ' . $class;
                    $classLevel->save();
                }
            }
        }
    }
}
