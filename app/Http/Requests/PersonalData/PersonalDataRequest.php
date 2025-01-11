<?php

namespace App\Http\Requests\PersonalData;

use Illuminate\Foundation\Http\FormRequest;

class PersonalDataRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'user_id' => ['required', 'integer'],
            'place_of_birth' => ['required'],
            'data_of_birth' => ['required', 'date'],
            'gender' => ['required'],
            'child_to' => ['required', 'integer'],
            'number_of_brothers' => ['required', 'integer'],
            'status_of_child' => ['required'],
            'religion' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
