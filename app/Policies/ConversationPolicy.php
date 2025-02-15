<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Conversation $conversation): bool
    {
        if ($user->hasRole('user')) return $user->id === $conversation->user_id;
        if ($user->hasRole('admin')) return optional($user->admin)->educational_institution_id === optional(optional($conversation->user)->student)->educational_institution_id;

        return true;
    }

    public function delete(User $user, Conversation $conversation): bool
    {
        if ($user->hasRole('user')) return $user->id === $conversation->user_id;
        if ($user->hasRole('admin')) return optional($user->admin)->educational_institution_id === optional(optional($conversation->user)->student)->educational_institution_id;

        return true;
    }
}
