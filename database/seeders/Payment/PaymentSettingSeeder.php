<?php

namespace Database\Seeders\Payment;

use App\Models\PaymentSetting;
use Illuminate\Database\Seeder;

class PaymentSettingSeeder extends Seeder
{
    public function run(): void
    {
        $paymentSetting = new PaymentSetting();
        $paymentSetting->payment_method = 'PAYMENT_GATEWAY';
        $paymentSetting->save();
    }
}
