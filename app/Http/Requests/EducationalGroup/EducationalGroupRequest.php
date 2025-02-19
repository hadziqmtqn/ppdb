<?php

namespace App\Http\Requests\EducationalGroup;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class EducationalGroupRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:educational_groups,name'],
            'next_educational_level_id' => ['required', 'integer', 'exists:educational_levels,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'next_educational_level_id' => 'level pendidikan selanjutnya',
        ];
    }
}
