<?php

namespace Database\Seeders\References;

use App\Models\DistanceToSchool;
use Illuminate\Database\Seeder;

class DistanceToSchoolSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Kurang dari 5 Km',
            'Antara 5 - 10 Km',
            'Antara 11 - 15 Km',
            'Antara 16 - 20 Km',
            'Lebih dari 21 Km'
                 ] as $item) {
            $distanceToSchool = new DistanceToSchool();
            $distanceToSchool->name = $item;
            $distanceToSchool->save();
        }
    }
}
