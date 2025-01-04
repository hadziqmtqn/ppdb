<?php

namespace App\Http\Requests\RegistrationPath;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationPathRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:registration_paths,name'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
