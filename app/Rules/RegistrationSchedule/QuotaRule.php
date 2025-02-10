<?php

namespace App\Rules\RegistrationSchedule;

use App\Models\RegistrationSchedule;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class QuotaRule implements ValidationRule
{
    protected mixed $slug;

    /**
     * @param mixed $slug
     */
    public function __construct(mixed $slug)
    {
        $this->slug = $slug;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $registrationSchedule = RegistrationSchedule::filterBySlug($this->slug)
            ->first();

        if ($registrationSchedule) {
            $quota = ((optional($registrationSchedule)->quota ?? 0) - optional($registrationSchedule)->remaining_quota ?? 0);

            if ($value < $quota) $fail('Kuota tidak boleh kurang dari jumlah siswa terdaftar sebanyak ' . $quota);
        }
    }
}
