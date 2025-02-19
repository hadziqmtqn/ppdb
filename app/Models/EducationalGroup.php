<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EducationalGroup extends Model
{
    protected $fillable = [
        'slug',
        'code',
        'name',
        'next_educational_level_id',
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

        static::creating(function (EducationalGroup $educationalGroup) {
            $educationalGroup->slug = Str::uuid()->toString();
            $educationalGroup->code = strtoupper(Str::slug($educationalGroup->name));
        });

        static::updating(function (EducationalGroup $educationalGroup) {
            $educationalGroup->code = strtoupper(Str::slug($educationalGroup->name));
        });
    }

    public function nextEducationalLevel(): BelongsTo
    {
        return $this->belongsTo(EducationalLevel::class, 'next_educational_level_id');
    }
}
