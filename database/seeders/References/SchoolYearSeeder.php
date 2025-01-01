<?php

namespace Database\Seeders\References;

use App\Models\SchoolYear;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class SchoolYearSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/school-year.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $schoolYear = new SchoolYear();
            $schoolYear->first_year = $row['first_year'];
            $schoolYear->last_year = $row['last_year'];
            $schoolYear->is_active = $row['is_active'] === 'true';
            $schoolYear->save();
        }
    }
}
