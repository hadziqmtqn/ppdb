<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Transportation extends Model
{
    protected $fillable = [
        'slug',
        'name',
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

        static::creating(function (Transportation $transportation) {
            $transportation->slug = Str::uuid()->toString();
        });
    }

    public function placeOfRecidences(): HasMany
    {
        return $this->hasMany(Residence::class, 'transportation_id');
    }
}
