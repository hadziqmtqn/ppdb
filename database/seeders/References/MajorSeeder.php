<?php

namespace Database\Seeders\References;

use App\Models\EducationalInstitution;
use App\Models\Major;
use Illuminate\Database\Seeder;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        $educationalInstitutions = EducationalInstitution::whereHas('educationalLevel', function ($query) {
            $query->where('code', 'SMA');
        })
            ->get();

        foreach ($educationalInstitutions as $educationalInstitution) {
            foreach (['MIPA', 'IPS', 'Bahasa'] as $item) {
                $major = new Major();
                $major->educational_institution_id = $educationalInstitution->id;
                $major->name = $item;
                $major->save();
            }
        }
    }
}
