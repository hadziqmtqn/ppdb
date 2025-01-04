<?php

namespace Database\Seeders\References;

use App\Models\RegistrationPath;
use Illuminate\Database\Seeder;

class RegistrationPathSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Regular', 'Prestasi'] as $item) {
            $registrationPath = new RegistrationPath();
            $registrationPath->name = $item;
            $registrationPath->save();
        }
    }
}
