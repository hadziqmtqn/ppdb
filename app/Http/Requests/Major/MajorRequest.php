<?php

namespace App\Http\Requests\Major;

use Illuminate\Foundation\Http\FormRequest;

class MajorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'name' => ['required', 'unique:majors,name'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
