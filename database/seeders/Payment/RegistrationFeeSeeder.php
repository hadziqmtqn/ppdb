<?php

namespace Database\Seeders\Payment;

use App\Models\RegistrationFee;
use App\Models\SchoolYear;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class RegistrationFeeSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/payment/registration-fee.csv'))
            ->setHeaderOffset(0);

        $schoolYear = SchoolYear::active()
            ->firstOrFail();

        foreach ($rows as $row) {
            $registrationFee = new RegistrationFee();
            $registrationFee->educational_institution_id = $row['educational_institution_id'];
            $registrationFee->school_year_id = $schoolYear->id;
            $registrationFee->type_of_payment = $row['type_of_payment'];
            $registrationFee->name = $row['name'];
            $registrationFee->registration_status = $row['registration_status'];
            $registrationFee->amount = $row['amount'];
            $registrationFee->save();
        }
    }
}
