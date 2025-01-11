<?php

namespace App\Http\Requests\PlaceOfRecidence;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOfRecidenceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'user_id' => ['required', 'integer'],
            'province' => ['required'],
            'city' => ['required'],
            'district' => ['required'],
            'village' => ['required'],
            'street' => ['required'],
            'postal_code' => ['required'],
            'distince_to_school_id' => ['required', 'integer'],
            'transportation_id' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
