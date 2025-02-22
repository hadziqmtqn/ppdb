<?php

namespace Database\Seeders\References;

use App\Models\EducationalGroup;
use App\Models\PreviousSchoolReference;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class PreviousSchoolReferenceSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws InvalidArgument
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/school-references.csv'))
            ->setHeaderOffset(0)
            ->setDelimiter(';');

        foreach ($rows as $row) {
            $previousSchoolReference = new PreviousSchoolReference();
            $previousSchoolReference->educational_group_id = EducationalGroup::selectByCode($row['educational_group'])->id;
            $previousSchoolReference->npsn = $row['npsn'];
            $previousSchoolReference->name = $row['name'];
            $previousSchoolReference->province = $row['province'];
            $previousSchoolReference->city = $row['city'];
            $previousSchoolReference->district = $row['district'];
            $previousSchoolReference->village = $row['village'];
            $previousSchoolReference->street = $row['street'];
            $previousSchoolReference->status = $row['status'];
            $previousSchoolReference->save();
        }
    }
}
