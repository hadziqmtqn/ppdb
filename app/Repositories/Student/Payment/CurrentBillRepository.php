<?php

namespace App\Repositories\Student\Payment;

use App\Models\RegistrationFee;
use App\Models\User;

class CurrentBillRepository
{
    protected RegistrationFee $registrationFee;

    public function __construct(RegistrationFee $registrationFee)
    {
        $this->registrationFee = $registrationFee;
    }

    public function getRegistrationFee(User $user)
    {
        return $this->registrationFee
            ->educationalInstitutionId(optional($user->student)->educational_institution_id)
            ->schoolYearId(optional($user->student)->school_year_id)
            ->active()
            ->where(function ($query) use ($user) {
                $query->where(function ($query) use ($user) {
                    $query->where('registration_status', 'siswa_belum_diterima')
                        ->whereDoesntHave('paymentTransaction', function ($query) use ($user) {
                            $query->where('user_id', $user->id);
                        });
                })
                    ->when(optional($user->student)->registration_status == 'diterima', function ($query) {
                        $query->orWhere(function ($query) {
                            $query->where('registration_status', 'siswa_diterima')
                                ->where(function ($query) {
                                    $query->whereDoesntHave('paymentTransaction')
                                        ->orWhereHas('paymentTransaction', function ($query) {
                                            $query->where('paid_rest', '!=', 0);
                                        });
                                });
                        });
                    });
            });
    }
}
