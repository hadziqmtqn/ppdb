<?php

namespace App\Http\Requests\Student;

use App\Rules\Student\ValidationRule;
use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class ValidationRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'registration_validation' => ['required', 'in:"belum_divalidasi","valid","tidak_valid"', new ValidationRule($this->route('user')->username)]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'registration_validation' => 'validasi pendaftaran'
        ];
    }
}
