<?php

namespace App\Http\Requests\Application;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'foundation' => ['required'],
            'description' => ['nullable'],
            'website' => ['nullable', 'url'],
            'main_website' => ['nullable', 'url'],
            'register_verification' => ['required', 'boolean'],
            'notification_method' => ['required', 'in:email,whatsapp'],
            'whatsapp_number' => ['required', 'min_digits:10', 'max_digits:13'],
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
            'foundation' => 'nama yayasan',
            'description' => 'deskripsi',
            'website' => 'website',
            'main_website' => 'website utama',
            'register_verification' => 'verifikasi akun',
            'notification_method' => 'metode notifikasi',
            'whatsapp_number' => 'no. whatsapp',
            'logo' => 'logo',
        ];
    }
}
