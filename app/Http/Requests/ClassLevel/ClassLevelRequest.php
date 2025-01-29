<?php

namespace App\Http\Requests\ClassLevel;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class ClassLevelRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'registration_category_id' => ['required', 'integer', 'exists:registration_categories,id'],
            'name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'educational_institution_id' => 'lembaga',
            'registration_category_id' => 'kategori pendaftaran',
            'name' => 'nama',
        ];
    }
}
