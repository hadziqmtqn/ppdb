<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email', 'unique:users,email'],
            'educational_institution_id' => ['required_if:role_id,2', 'nullable', 'integer', 'exists:educational_institutions,id'],
            'whatsapp_number' => ['required', 'numeric'],
            'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:700']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'educational_institution_id.required_if' => ':attrobute wajib diisi jika Role: Admin',
            'password.regex' => ':attribute minimal terdiri dari angka, 1 huruf besar, huruf kecil, dan karakter khusus',
        ];
    }

    public function attributes(): array
    {
        return [
            'role_id' => 'role',
            'name' => 'nama',
            'email' => 'email',
            'educational_institution_id' => 'lembaga',
            'whatsapp_number' => 'no. whatsapp',
            'password' => 'kata sandi',
            'password_confirmation' => 'konfirmasi kata sandi',
            'photo' => 'foto'
        ];
    }
}
