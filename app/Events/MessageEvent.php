<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;
    public int $userId;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->userId = auth()->id(); // Attach the authenticated user's ID
    }

    public function broadcastOn(): Channel
    {
        return new Channel('conversation.' . $this->message->conversation->slug);
    }

    public function broadcastWith(): array
    {
        return [
            'username' => ucwords(strtolower(optional($this->message->user)->name)),
            'message' => $this->message->message,
            'date' => $this->message->created_at->isoFormat('DD MMM Y HH:mm'),
            'userId' => $this->userId, // Include the authenticated user's ID
        ];
    }
}
