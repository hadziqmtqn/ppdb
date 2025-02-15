<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Conversation $conversation): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Conversation $conversation): bool
    {
    }

    public function delete(User $user, Conversation $conversation): bool
    {
    }

    public function restore(User $user, Conversation $conversation): bool
    {
    }

    public function forceDelete(User $user, Conversation $conversation): bool
    {
    }
}
