<?php

namespace Database\Seeders\References;

use App\Models\RegistrationCategory;
use Illuminate\Database\Seeder;

class RegistrationCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Baru', 'Pindahan'] as $item) {
            $registrationCategory = new RegistrationCategory();
            $registrationCategory->name = $item;
            $registrationCategory->save();
        }
    }
}
