<?php

namespace Database\Seeders;

use App\Models\EducationalInstitution;
use App\Models\EducationalLevel;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class EducationalInstitutionSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(base_path('database/import/educational-institution.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $educationalInstitution = new EducationalInstitution();
            $educationalInstitution->name = $row['name'];
            $educationalInstitution->educational_level_id = EducationalLevel::getIdByCode($row['educational-level-code']);
            $educationalInstitution->email = $row['email'];
            $educationalInstitution->website = $row['website'];
            $educationalInstitution->save();
        }
    }
}
