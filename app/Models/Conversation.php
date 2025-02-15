<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Conversation extends Model
{
    protected $fillable = [
        'slug',
        'user_id',
        'admin_id',
        'subject',
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

        static::creating(function (Conversation $conversation) {
            $conversation->slug = Str::uuid()->toString();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
