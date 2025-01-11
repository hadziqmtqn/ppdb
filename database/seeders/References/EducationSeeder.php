<?php

namespace Database\Seeders\References;

use App\Models\Education;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class EducationSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/education.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $education = new Education();
            $education->name = $row['name'];
            $education->save();
        }
    }
}
