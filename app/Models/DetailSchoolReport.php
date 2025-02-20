<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailSchoolReport extends Model
{
    protected $fillable = [
        'school_report_id',
        'lesson_id',
        'score',
    ];

    public function schoolReport(): BelongsTo
    {
        return $this->belongsTo(SchoolReport::class);
    }

    // TODO Scope
    public function scopeLessonId(Builder $query, $lessonId): Builder
    {
        return $query->where('lesson_id', $lessonId);
    }
}
