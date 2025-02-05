<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class RegistrationPath extends Model
{
    protected $fillable = [
        'slug',
        'educational_institution_id',
        'code',
        'name',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string',
            'is_active' => 'boolean'
        ];
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (RegistrationPath $registrationPath) {
            $registrationPath->slug = Str::uuid()->toString();
            $registrationPath->code = strtoupper(Str::slug($registrationPath->name));
        });

        static::created(function (RegistrationPath $registrationPath) {
            self::where([
                'educational_institution_id' => $registrationPath->educational_institution_id,
                'code' => $registrationPath->code
            ])
                ->where('id', '!=', $registrationPath->id)
                ->update(['is_active' => false]);
        });

        static::updating(function (RegistrationPath $registrationPath) {
            $registrationPath->code = strtoupper(Str::slug($registrationPath->name));
        });

        static::updated(function (RegistrationPath $registrationPath) {
            self::where([
                'educational_institution_id' => $registrationPath->educational_institution_id,
                'code' => $registrationPath->code
            ])
                ->where('id', '!=', $registrationPath->id)
                ->update(['is_active' => false]);
        });
    }

    public function educationalInstitution(): BelongsTo
    {
        return $this->belongsTo(EducationalInstitution::class);
    }

    // TODO Scope
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeEducationalInstitutionId(Builder $query, $educationalInstitutionId): Builder
    {
        return $query->where('educational_institution_id', $educationalInstitutionId);
    }

    public function scopeFilterByEducationalInstitution(Builder $query): Builder
    {
        $auth = auth()->user();

        return $query->when(!$auth->hasRole('super-admin'), fn($query) => $query->where('educational_institution_id'), optional(optional($auth)->admin)->educational_institution_id);
    }
}
