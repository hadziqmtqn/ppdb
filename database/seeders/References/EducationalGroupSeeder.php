<?php

namespace Database\Seeders\References;

use App\Models\EducationalGroup;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class EducationalGroupSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/educational-group.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $educationalGroup = new EducationalGroup();
            $educationalGroup->name = $row['name'];
            $educationalGroup->next_educational_level_id = $row['next_educational_level_id'];
            $educationalGroup->save();
        }
    }
}
