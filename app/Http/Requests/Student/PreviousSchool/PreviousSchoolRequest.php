<?php

namespace App\Http\Requests\Student\PreviousSchool;

use Illuminate\Foundation\Http\FormRequest;

class PreviousSchoolRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'school_name' => ['required'],
            'status' => ['required'],
            'address' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
