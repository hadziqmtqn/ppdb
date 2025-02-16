<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Conversation extends Model implements HasMedia
{
    use InteractsWithMedia;

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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    // TODO Scope
    public function scopeFilterByStudent(Builder $query): Builder
    {
        $auth = auth()->user();

        $query->when($auth->hasRole('user'), function ($query) use ($auth) {
            $query->where('user_id', $auth->id);
        });

        $query->when($auth->hasRole('admin'), function ($query) use ($auth) {
            $query->whereHas('user.student', fn($query) => $query->where('educational_institution_id', optional($auth->admin)->educational_institution_id));
        });

        return $query;
    }
}
