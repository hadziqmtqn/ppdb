<?php

namespace App\Http\Requests\RegistrationStep;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationStepRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'serial_number' => ['required', 'integer'],
            'title' => ['required'],
            'description' => ['required'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:500'],
            'is_active' => ['required', 'boolean']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'serial_number' => 'nomor urut',
            'title' => 'judul',
            'description' => 'deskripsi',
            'image' => 'gambar',
            'is_active' => 'status aktif'
        ];
    }
}
