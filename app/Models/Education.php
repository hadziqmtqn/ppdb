<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Education extends Model
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

        static::creating(function (Education $education) {
            $education->slug = Str::uuid()->toString();
        });
    }

    public function fatherEducations(): HasMany
    {
        return $this->hasMany(Family::class, 'father_education_id');
    }

    public function motherEducations(): HasMany
    {
        return $this->hasMany(Family::class, 'mother_education_id');
    }

    public function guardianEducations(): HasMany
    {
        return $this->hasMany(Family::class, 'guardian_education_id');
    }
}
