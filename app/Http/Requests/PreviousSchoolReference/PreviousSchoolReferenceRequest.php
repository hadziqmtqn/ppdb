<?php

namespace App\Http\Requests\PreviousSchoolReference;

use Illuminate\Foundation\Http\FormRequest;

class PreviousSchoolReferenceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'educational_group_id' => ['required', 'integer'],
            'npsn' => ['nullable'],
            'name' => ['required'],
            'province' => ['nullable'],
            'city' => ['nullable'],
            'district' => ['nullable'],
            'village' => ['nullable'],
            'address' => ['nullable'],
            'status' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
