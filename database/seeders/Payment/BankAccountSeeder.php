<?php

namespace Database\Seeders\Payment;

use App\Models\BankAccount;
use App\Models\PaymentChannel;
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
            $paymentChannel = PaymentChannel::findByCode($row['payment_channel_code']);

            $bankAccount = new BankAccount();
            $bankAccount->payment_channel_id = $paymentChannel->id;
            $bankAccount->account_name = $row['account_name'];
            $bankAccount->account_number = $row['account_number'];
            $bankAccount->educational_institution_id = $row['educational_institution_id'];
            $bankAccount->save();
        }
    }
}
