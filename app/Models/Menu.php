<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Menu extends Model
{
    use HasSlug;

    protected $fillable = [
        'slug',
        'serial_number',
        'name',
        'type',
        'main_menu',
        'visibility',
        'url',
        'icon',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string',
            'visibility' => 'array'
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function scopeMainMenu(Builder $query): Builder
    {
        return $query->where('type', 'main_menu');
    }

    public function scopeSearch(Builder $query, $search): Builder
    {
        return $query->when($search['search'] ?? null, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search['search'] . '%');
        });
    }
}
