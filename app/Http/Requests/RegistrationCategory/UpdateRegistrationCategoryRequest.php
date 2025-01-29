<?php

namespace App\Http\Requests\RegistrationCategory;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationCategoryRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:registration_categories,name,' . $this->route('registrationCategory')->slug . ',slug'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
