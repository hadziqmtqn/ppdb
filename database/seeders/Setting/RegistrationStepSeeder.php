<?php

namespace Database\Seeders\Setting;

use App\Models\RegistrationStep;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class RegistrationStepSeeder extends Seeder
{
    /**
     * @throws InvalidArgument
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/registration-steps.csv'))
            ->setHeaderOffset(0)
            ->setDelimiter(';');

        foreach ($rows as $row) {
            $registrationStep = new RegistrationStep();
            $registrationStep->serial_number = $row['serial_number'];
            $registrationStep->title = $row['title'];
            $registrationStep->description = $row['description'];
            $registrationStep->save();
        }
    }
}
