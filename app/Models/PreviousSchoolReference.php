<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PreviousSchoolReference extends Model
{
    protected $fillable = [
        'slug',
        'educational_group_id',
        'npsn',
        'name',
        'province',
        'city',
        'district',
        'village',
        'street',
        'status',
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

        static::creating(function (PreviousSchoolReference $previousSchoolReference) {
            $previousSchoolReference->slug = Str::uuid()->toString();
            $previousSchoolReference->name = strtoupper($previousSchoolReference->name);
        });

        static::updating(function (PreviousSchoolReference $previousSchoolReference) {
            $previousSchoolReference->name = strtoupper($previousSchoolReference->name);
        });
    }

    public function educationalGroup(): BelongsTo
    {
        return $this->belongsTo(EducationalGroup::class);
    }

    public function previousSchools(): HasMany
    {
        return $this->hasMany(PreviousSchool::class, 'previous_school_reference_id');
    }

    // TODO Scope
    public function scopeEducationalGroupId(Builder $query, $educationalGroupId): Builder
    {
        return $query->where('educational_group_id', $educationalGroupId);
    }

    public function scopeSearch(Builder $query, $request): Builder
    {
        $search = $request['search'] ?? null;

        return $query->when($search, fn($query) => $query->whereAny(['name', 'npsn'], 'LIKE', '%' . $search . '%'));
    }

    public function scopeFilterData(Builder $query, $request): Builder
    {
        $village = $request['village'] ?? null;

        $query->where([
            'educational_group_id' => $request['educational_group_id'] ?? null,
            'province' => $request['province'] ?? null,
            'city' => $request['city'] ?? null,
            'district' => $request['district'] ?? null
        ]);

        $query->when($village, fn($query) => $query->where('village', $village));

        return $query;
    }
}
