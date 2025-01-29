<?php

namespace App\Http\Requests\Student\Family;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class FamilyRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'national_identification_number' => ['required', 'digits:16'],
            'family_card_number' => ['required', 'max_digits:16'],
            'father_name' => ['required', 'min:3'],
            'father_education_id' => ['nullable', 'integer', 'exists:education,id'],
            'father_profession_id' => ['nullable', 'integer', 'exists:professions,id'],
            'father_income_id' => ['nullable', 'integer', 'exists:incomes,id'],
            'mother_name' => ['required', 'min:3'],
            'mother_education_id' => ['nullable', 'integer', 'exists:education,id'],
            'mother_profession_id' => ['nullable', 'integer', 'exists:professions,id'],
            'mother_income_id' => ['nullable', 'integer', 'exists:incomes,id'],
            'have_a_guardian' => ['required', 'boolean'],
            'guardian_name' => ['nullable', 'min:3'],
            'guardian_education_id' => ['nullable', 'integer', 'exists:education,id'],
            'guardian_profession_id' => ['nullable', 'integer', 'exists:professions,id'],
            'guardian_income_id' => ['nullable', 'integer', 'exists:incomes,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'national_identification_number' => 'nomor induk kependudukan',
            'family_card_number' => 'nomor kartu keluarga',
            'father_name' => 'nama ayah kandung',
            'father_education_id' => 'pendidikan ayah kandung',
            'father_profession_id' => 'pekerjaan ayah kandung',
            'father_income_id' => 'penghasilan ayah kandung',
            'mother_name' => 'nama ibu kandung',
            'mother_education_id' => 'pendidikan ibu kandung',
            'mother_profession_id' => 'pekerjaan ibu kandung',
            'mother_income_id' => 'penghasilan ibu kandung',
            'have_a_guardian' => 'punya wali',
            'guardian_name' => 'nama wali',
            'guardian_education_id' => 'pendidikan wali',
            'guardian_profession_id' => 'pekerjaan wali',
            'guardian_income_id' => 'penghasilan wali',
        ];
    }
}
