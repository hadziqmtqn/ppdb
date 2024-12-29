<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'description' => ['nullable'],
            'website' => ['nullable', 'url'],
            'main_website' => ['nullable', 'url'],
            'register_verification' => ['required', 'boolean'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:700'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'description' => 'deskripsi',
            'website' => 'website',
            'main_website' => 'website utama',
            'register_verification' => 'verifikasi akun',
            'logo' => 'logo',
        ];
    }
}
