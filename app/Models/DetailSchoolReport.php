<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailSchoolReport extends Model
{
    protected $fillable = [
        'school_report_id',
        'lesson_id',
        'score',
    ];
}
