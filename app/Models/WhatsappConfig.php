<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WhatsappConfig extends Model
{
    protected $fillable = [
        'slug',
        'domain',
        'api_key',
        'provider',
        'is_active'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (WhatsappConfig $whatsappConfig) {
            $whatsappConfig->slug = Str::uuid()->toString();
        });

        static::created(function (WhatsappConfig $whatsappConfig) {
            if ($whatsappConfig->is_active) {
                self::where('id', '!=', $whatsappConfig->id)
                    ->update(['is_active' => false]);
            }
        });

        static::updated(function (WhatsappConfig $whatsappConfig) {
            if ($whatsappConfig->is_active) {
                self::where('id', '!=', $whatsappConfig->id)
                    ->update(['is_active' => false]);
            }
        });
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
