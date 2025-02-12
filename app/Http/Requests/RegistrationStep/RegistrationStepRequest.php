<?php

namespace App\Http\Requests\RegistrationStep;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationStepRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'serial_number' => ['required', 'integer'],
            'title' => ['required'],
            'description' => ['required'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:300']
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
            'image' => 'gambar'
        ];
    }
}
