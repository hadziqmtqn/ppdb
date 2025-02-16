<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('conversation.' . $this->message->conversation_id);
    }

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'username' => optional($this->message->user)->name,
            'avatar' => url('https://ui-avatars.com/api/?name='. optional($this->message->user)->name .'&color=7F9CF5&background=EBF4FF'),
            'date' => $this->message->created_at->isoFormat('DD MMM Y HH:mm'),
        ];
    }
}
