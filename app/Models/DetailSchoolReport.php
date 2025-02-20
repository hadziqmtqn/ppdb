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

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    // TODO Scope
    public function scopeLessonId(Builder $query, $lessonId): Builder
    {
        return $query->where('lesson_id', $lessonId);
    }

    public function scopeSchoolReportId(Builder $query, $schoolReportId): Builder
    {
        return $query->where('school_report_id', $schoolReportId);
    }
}
