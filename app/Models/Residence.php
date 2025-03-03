<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Residence extends Model
{
    protected $fillable = [
        'slug',
        'user_id',
        'province',
        'city',
        'district',
        'village',
        'street',
        'postal_code',
        'distance_to_school_id',
        'transportation_id',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string',
        ];
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (Residence $placeOfRecidence) {
            $placeOfRecidence->slug = Str::uuid()->toString();
        });
    }

    public function scopeUserId(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function distanceToSchool(): BelongsTo
    {
        return $this->belongsTo(DistanceToSchool::class);
    }

    public function transportation(): BelongsTo
    {
        return $this->belongsTo(Transportation::class);
    }
}
