<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PlaceOfRecidence extends Model
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
        'distince_to_school_id',
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

        static::creating(function (PlaceOfRecidence $placeOfRecidence) {
            $placeOfRecidence->slug = Str::uuid()->toString();
        });
    }
}
