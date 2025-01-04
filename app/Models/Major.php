<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Major extends Model
{
    protected $fillable = [
        'slug',
        'educational_institution_id',
        'code',
        'name',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string'
        ];
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (Major $major) {
            $major->slug = Str::uuid()->toString();
            $major->code = strtoupper(Str::slug($major->name));
        });

        static::creating(function (Major $major) {
            $major->code = strtoupper(Str::slug($major->name));
        });
    }
}
