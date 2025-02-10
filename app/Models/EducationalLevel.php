<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
            $educationalLevel->code = strtoupper(Str::slug($educationalLevel->name));
        });

        static::updating(function (EducationalLevel $educationalLevel) {
            $educationalLevel->code = strtoupper(Str::slug($educationalLevel->name));
        });
    }

    public static function getIdByCode($code): ?int
    {
        return self::query()->where('code', $code)->first()->id;
    }

    public function educationalInstitutions(): HasMany
    {
        return $this->hasMany(EducationalInstitution::class, 'educational_level_id');
    }
}
