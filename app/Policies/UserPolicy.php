<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewStudent(User $user, User $model): bool
    {
        if ($user->hasRole('admin')) return optional($user->admin)->educational_institution_id === optional($model->student)->educational_institution_id; elseif ($user->hasRole('user')) return $user->id === $model->id;

        return true;
    }

    public function store(User $user, User $model): bool
    {
        if ($user->hasRole('admin')) return optional($user->admin)->educational_institution_id === optional($model->student)->educational_institution_id; elseif ($user->hasRole('user')) return $user->id === $model->id;

        return true;
    }

    public function studentDestroy(User $user, User $model): bool
    {
        if ($user->hasRole('admin')) return optional($user->admin)->educational_institution_id === optional($model->student)->educational_institution_id;

        return true;
    }
}
