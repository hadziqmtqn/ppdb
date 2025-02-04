<?php

namespace Database\Seeders\Payment;

use App\Models\PaymentChannel;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class PaymentChannelSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/payment/payment-channel.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $paymentChannel = new PaymentChannel();
            $paymentChannel->name = $row['name'];
            $paymentChannel->code = $row['code'];
            $paymentChannel->is_active = $row['is_active'] == 'true' ?? false;
            $paymentChannel->save();
        }
    }
}
