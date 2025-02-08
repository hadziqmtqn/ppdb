<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Payment $payment): bool
    {
        if ($user->hasRole('admin')) return optional($user->admin)->educational_institution_id === optional(optional($payment->user)->student)->educational_institution_id; elseif ($user->hasRole('user')) return $user->id === $payment->user_id;

        return true;
    }

    public function store(User $user, Payment $payment): bool
    {
        if ($user->hasRole('admin')) return optional($user->admin)->educational_institution_id === optional(optional($payment->user)->student)->educational_institution_id; elseif ($user->hasRole('user')) return $user->id === $payment->user_id;

        return true;
    }

    public function validation(User $user, Payment $payment): bool
    {
        if ($user->hasRole('user')) return false;

        if ($user->hasRole('admin')) return optional($user->admin)->educational_institution_id === optional(optional($payment->user)->student)->educational_institution_id;

        return true;
    }

    public function destroy(User $user, Payment $payment): bool
    {
        if ($user->hasRole('user')) return false;

        if ($user->hasRole('admin')) return optional($user->admin)->educational_institution_id === optional(optional($payment->user)->student)->educational_institution_id;

        return true;
    }
}
