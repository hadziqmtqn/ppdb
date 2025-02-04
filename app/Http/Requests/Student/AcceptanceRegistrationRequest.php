<?php

namespace App\Http\Requests\Student;

use App\Rules\Student\ValidationRule;
use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class AcceptanceRegistrationRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'registration_status' => ['required', 'in:"belum_diterima","diterima","ditolak"', new ValidationRule($this->route('user')->username)]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'registration_status' => 'status registrasi'
        ];
    }
}
