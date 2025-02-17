<?php

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::routes(['middleware' => ['auth']]);

Broadcast::channel('conversation.{conversationId}', function (User $user, $conversationId) {
    // Logic to check if the user can access the conversation
    return Conversation::where('id', $conversationId)
        ->where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere('admin_id', $user->id);
        })
        ->exists();
});