<?php

namespace App\Repositories\Student\Payment;

use App\Models\PaymentTransaction;
use App\Models\User;

class PaymentTransactionRepository
{
    protected PaymentTransaction $paymentTransaction;

    public function __construct(PaymentTransaction $paymentTransaction)
    {
        $this->paymentTransaction = $paymentTransaction;
    }

    public function getPaymentRegistrationExists(User $user): bool
    {
        $user->load('student');

        return $this->paymentTransaction->whereHas('payment', function ($query) use ($user) {
            $query->where([
                'user_id' => $user->id,
                'status' => 'PAID'
            ]);
        })
            ->whereHas('registrationFee', function ($query) use ($user) {
                $query->educationalInstitutionId(optional($user->student)->educational_institution_id)
                    ->schoolYearId(optional($user->student)->school_year_id)
                    ->registrationStatus('siswa_belum_diterima')
                    ->active();
            })
            ->exists();
    }
}
