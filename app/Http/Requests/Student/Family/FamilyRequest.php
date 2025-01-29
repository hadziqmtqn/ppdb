<?php

namespace App\Http\Requests\Student\Family;

use Illuminate\Foundation\Http\FormRequest;

class FamilyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'user_id' => ['required', 'integer'],
            'national_identification_number' => ['required'],
            'family_card_number' => ['required'],
            'father_name' => ['required'],
            'father_education_id' => ['nullable', 'integer'],
            'father_profession_id' => ['nullable', 'integer'],
            'father_income_id' => ['nullable', 'integer'],
            'mother_name' => ['required'],
            'mother_education_id' => ['nullable', 'integer'],
            'mother_profession_id' => ['nullable', 'integer'],
            'mother_income_id' => ['nullable', 'integer'],
            'have_a_guardian' => ['boolean'],
            'guardian_name' => ['nullable'],
            'guardian_education_id' => ['nullable', 'integer'],
            'guardian_profession_id' => ['nullable', 'integer'],
            'guardian_income_id' => ['nullable', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
