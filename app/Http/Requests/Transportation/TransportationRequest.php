<?php

namespace App\Http\Requests\Transportation;

use Illuminate\Foundation\Http\FormRequest;

class TransportationRequest extends FormRequest
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
