<?php

namespace App\Http\Requests\RegistrationCategory;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationCategoryRequest extends FormRequest
{
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
