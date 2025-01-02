<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassLevelRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'educational_institution_id' => ['required', 'integer'],
            'registration_category_id' => ['required', 'integer'],
            'code' => ['required'],
            'name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
