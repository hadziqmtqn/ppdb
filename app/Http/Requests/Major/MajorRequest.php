<?php

namespace App\Http\Requests\Major;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class MajorRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
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
            'name' => 'nama',
        ];
    }
}
