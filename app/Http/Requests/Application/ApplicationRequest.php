<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'website' => ['nullable', 'url'],
            'main_website' => ['nullable', 'url'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
