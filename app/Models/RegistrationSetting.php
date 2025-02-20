<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class RegistrationSetting extends Model
{
    protected $fillable = [
        'slug',
        'educational_institution_id',
        'accepted_with_school_report',
        'school_report_semester'
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string',
            'accepted_with_school_report' => 'boolean',
            'school_report_semester' => 'array'
        ];
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (RegistrationSetting $registrationSetting) {
            $registrationSetting->slug = Str::uuid()->toString();
        });
    }

    public function educationalInstitution(): BelongsTo
    {
        return $this->belongsTo(EducationalInstitution::class);
    }

    // TODO Scope
    public function scopeEducationalInstitutionId(Builder $query, $educationalInstitutionId): Builder
    {
        return $query->where('educational_institution_id', $educationalInstitutionId);
    }
}
