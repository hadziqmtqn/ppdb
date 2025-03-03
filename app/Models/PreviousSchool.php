<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class PreviousSchool extends Model
{
    protected $fillable = [
        'slug',
        'user_id',
        'previous_school_reference_id',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string'
        ];
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (PreviousSchool $previousSchool) {
            $previousSchool->slug = Str::uuid()->toString();
        });
    }

    public function previousSchoolReference(): BelongsTo
    {
        return $this->belongsTo(PreviousSchoolReference::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // TODO Scope
    public function scopeUserId(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
