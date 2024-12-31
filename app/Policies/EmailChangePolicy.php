<?php

namespace App\Policies;

use App\Models\EmailChange;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmailChangePolicy
{
    use HandlesAuthorization;

    public function verification(User $user, EmailChange $emailChange): bool
    {
        return $user->id === $emailChange->user_id;
    }
}
