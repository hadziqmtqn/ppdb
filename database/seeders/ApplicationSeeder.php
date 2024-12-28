<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $application = new Application();
        $application->name = 'PPDB Online';
        $application->website = 'https://ppdb.bkn.my.id';
        $application->main_website = 'https://bkn.my.id';
        $application->save();
    }
}
