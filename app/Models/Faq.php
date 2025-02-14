<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Faq extends Model
{
    protected $fillable = [
        'slug',
        'faq_category_id',
        'educational_institution_id',
        'title',
        'description',
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

        static::creating(function (Faq $faq) {
            $faq->slug = Str::uuid()->toString();
        });
    }

    public function faqCategory(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class);
    }

    public function educationalInstitution(): BelongsTo
    {
        return $this->belongsTo(EducationalInstitution::class);
    }

    public function scopeFilterData(Builder $query, $request): Builder
    {
        $search = $request['search'] ?? null;
        $faqCategoryId = $request['faq_category_id'] ?? null;
        $educationalInstitutionId = $request['educational_institution_id'] ?? null;

        $query->when($search, fn($query) => $query->whereAny(['title', 'description'], 'LIKE', '%' . $search . '%'));

        $query->where('faq_category_id', $faqCategoryId);

        $query->where(function ($query) use ($educationalInstitutionId) {
            $query->where('educational_institution_id', $educationalInstitutionId)
                ->orWhereNull('educational_institution_id');
        });

        return $query;
    }
}
