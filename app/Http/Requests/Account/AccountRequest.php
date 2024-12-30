<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id, 'email'],
            'current_password' => ['nullable'],
            'password' => ['nullable', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/', 'different:current_password'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:700'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'password.regex' => ':attribute minimal terdiri dari angka, 1 huruf besar, huruf kecil, dan karakter khusus',
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password' => 'Kata sandi sekarang',
            'password' => 'Kata sandi baru',
            'password_confirmation' => 'Konfirmasi kata sandi baru',
        ];
    }
}
