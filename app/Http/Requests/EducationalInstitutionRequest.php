<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationalInstitutionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'educational_level_id' => ['required', 'integer'],
            'name' => ['required'],
            'email' => ['nullable', 'email', 'max:254'],
            'website' => ['nullable'],
            'province' => ['nullable'],
            'city' => ['nullable'],
            'district' => ['nullable'],
            'village' => ['nullable'],
            'street' => ['nullable'],
            'postal_code' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
