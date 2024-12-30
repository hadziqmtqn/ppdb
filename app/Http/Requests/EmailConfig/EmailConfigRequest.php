<?php

namespace App\Http\Requests\EmailConfig;

use Illuminate\Foundation\Http\FormRequest;

class EmailConfigRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mail_username' => ['required'],
            'mail_password_app' => ['required'],
            'is_active' => ['required', 'boolean']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attribute(): array
    {
        return [
            'mail_username' => 'email pengguna',
            'mail_password_app' => 'kata sandi aplikasi',
            'is_active' => 'status aktif'
        ];
    }
}
