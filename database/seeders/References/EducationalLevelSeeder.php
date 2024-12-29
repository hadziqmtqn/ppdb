<?php

namespace Database\Seeders\References;

use App\Models\EducationalLevel;
use Illuminate\Database\Seeder;

class EducationalLevelSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['SD', 'SMP', 'SMA'] as $item) {
            $educationalLevel = new EducationalLevel();
            $educationalLevel->name = $item;
            $educationalLevel->save();
        }
    }
}
