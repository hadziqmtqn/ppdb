<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EducationalLevel extends Model
{
    protected $fillable = [
        'slug',
        'code',
        'name',
    ];

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (EducationalLevel $educationalLevel) {
            $educationalLevel->slug = Str::uuid()->toString();
            $educationalLevel->code = strtoupper($educationalLevel->name);
        });

        static::updating(function (EducationalLevel $educationalLevel) {
            $educationalLevel->code = strtoupper($educationalLevel->name);
        });
    }
}
