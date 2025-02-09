<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class AssetsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => ['required', 'array'],
            'file.*' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
