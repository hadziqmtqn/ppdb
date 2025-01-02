<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class RegistrationCategory extends Model
{
    protected $fillable = [
        'slug',
        'code',
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

        static::creating(function (RegistrationCategory $registrationCategory) {
            $registrationCategory->slug = Str::uuid()->toString();
            $registrationCategory->code = strtoupper(Str::slug($registrationCategory->name));
        });

        static::updating(function (RegistrationCategory $registrationCategory) {
            $registrationCategory->code = strtoupper(Str::slug($registrationCategory->name));
        });
    }

    public function classLevels(): HasMany
    {
        return $this->hasMany(ClassLevel::class, 'registration_category_id');
    }
}
