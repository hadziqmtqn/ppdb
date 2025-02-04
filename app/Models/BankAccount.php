<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BankAccount extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'code',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string',
            'is_active' => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (BankAccount $bankAccount) {
            $bankAccount->slug = Str::uuid()->toString();
        });
    }
}
