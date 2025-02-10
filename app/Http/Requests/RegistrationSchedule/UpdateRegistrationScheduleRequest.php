<?php

namespace App\Http\Requests\RegistrationSchedule;

use App\Rules\RegistrationSchedule\QuotaRule;
use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationScheduleRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', 'date_format:Y-m-d', 'before:end_date'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after:start_date'],
            'quota' => ['required', 'integer', new QuotaRule($this->route('registrationSchedule')->slug)]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'start_date' => 'tanggal mulai',
            'end_date' => 'tanggal berakhir',
            'quota' => 'kuota'
        ];
    }
}
