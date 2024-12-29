<?php

namespace App\Rules\Role;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Spatie\Permission\Models\Role;

class NameRule implements ValidationRule
{
    protected mixed $slug;

    public function __construct(mixed $slug)
    {
        $this->slug = $slug;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $existRole = Role::where('name', $value)
            ->where('slug', '!=', $this->slug)
            ->exists();

        if ($existRole) {
            $fail('Role ' . $value . ' telah digunakan.');
        }
    }
}
