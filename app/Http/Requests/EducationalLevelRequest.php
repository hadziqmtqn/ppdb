<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationalLevelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'code' => ['required'],
            'name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
