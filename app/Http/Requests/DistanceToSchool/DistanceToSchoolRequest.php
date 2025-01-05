<?php

namespace App\Http\Requests\DistanceToSchool;

use Illuminate\Foundation\Http\FormRequest;

class DistanceToSchoolRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
