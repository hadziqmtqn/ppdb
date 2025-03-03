<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DistanceToSchool extends Model
{
    protected $fillable = [
        'slug',
        'name',
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

        static::creating(function (DistanceToSchool $distanceToSchool) {
            $distanceToSchool->slug = Str::uuid()->toString();
        });
    }
}
