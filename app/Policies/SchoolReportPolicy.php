<?php

namespace App\Policies;

use App\Models\SchoolReport;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolReportPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, SchoolReport $schoolReport): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, SchoolReport $schoolReport): bool
    {
    }

    public function delete(User $user, SchoolReport $schoolReport): bool
    {
    }

    public function restore(User $user, SchoolReport $schoolReport): bool
    {
    }

    public function forceDelete(User $user, SchoolReport $schoolReport): bool
    {
    }
}
