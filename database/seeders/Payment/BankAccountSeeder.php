<?php

namespace Database\Seeders\Payment;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class BankAccountSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/payment/bank-account.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $bankAccount = new BankAccount();
            $bankAccount->name = $row['name'];
            $bankAccount->code = $row['code'];
            $bankAccount->is_active = $row['is_active'] === 'true' ?? false;
            $bankAccount->save();
        }
    }
}
