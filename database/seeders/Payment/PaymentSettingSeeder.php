<?php

namespace Database\Seeders\Payment;

use App\Models\EducationalInstitution;
use App\Models\PaymentSetting;
use Illuminate\Database\Seeder;

class PaymentSettingSeeder extends Seeder
{
    public function run(): void
    {
        $educationalInstitutions = EducationalInstitution::get();

        foreach ($educationalInstitutions as $educationalInstitution) {
            $paymentSetting = new PaymentSetting();
            $paymentSetting->educational_institution_id = $educationalInstitution->id;
            $paymentSetting->payment_method = $educationalInstitution->educational_level_id == 1 ? 'MANUAL_PAYMENT' : 'PAYMENT_GATEWAY';
            $paymentSetting->save();
        }
    }
}
