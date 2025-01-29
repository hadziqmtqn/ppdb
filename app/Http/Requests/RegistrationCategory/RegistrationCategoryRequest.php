<?php

namespace App\Http\Requests\RegistrationCategory;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationCategoryRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:registration_categories,name'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
