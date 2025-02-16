<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Message extends Model
{
    protected $fillable = [
        'slug',
        'conversation_id',
        'user_id',
        'message',
        'is_seen',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string',
            'is_seen' => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (Message $message) {
            $message->slug = Str::uuid()->toString();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*TODO Scope*/
    public function scopeConversationId(Builder $query, $conversationId): Builder
    {
        return $query->where('conversation_id', $conversationId);
    }
}
