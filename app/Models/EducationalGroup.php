<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    // TODO Scope
    public function scopeSearch(Builder $query, $request): Builder
    {
        $search = $request['search'] ?? null;

        return $query->when($search, fn($query) => $query->whereAny(['name'], 'LIKE', '%' . $search . '%'));
    }

    public function scopeFilter(Builder $query, $request): Builder
    {
        $educationalInstitutionId = $request['educational_institution_id'] ?? null;

        return $query->whereHas('nextEducationalLevel', function ($query) use ($educationalInstitutionId) {
                $query->whereHas('educationalInstitutions', function ($query) use ($educationalInstitutionId) {
                    $query->where('id', $educationalInstitutionId);
                });
            });
    }

    public static function selectByCode($code): EducationalGroup
    {
        return self::where('code', $code)
            ->firstOrFail();
    }
}
