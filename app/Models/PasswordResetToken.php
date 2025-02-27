<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $fillable = [
        'email',
        'token',
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'timestamp',
        ];
    }

    // TODO Scope
    public function scopeFilterByEmail(Builder $query, $email): Builder
    {
        return $query->where('email', $email);
    }
}
