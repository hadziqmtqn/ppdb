<?php

namespace App\Http\Requests\EducationalInstitution;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEducationalInstitutionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'educational_level_id' => ['required', 'integer', 'exists:educational_levels,id'],
            'name' => ['required'],
            'email' => ['nullable', 'email', 'max:254'],
            'website' => ['nullable'],
            'province' => ['nullable'],
            'city' => ['nullable'],
            'district' => ['nullable'],
            'village' => ['nullable'],
            'street' => ['nullable'],
            'postal_code' => ['nullable', 'integer', 'digits:5'],
            'profile' => ['nullable'],
            'is_active' => ['required', 'boolean'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:700'],
            'letterhead' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:500']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'educational_level_id' => 'level pendidikan',
            'name' => 'nama lembaga',
            'province' => 'provinsi',
            'city' => 'kota',
            'district' => 'kecamatan',
            'village' => 'kelurahan/desa',
            'street' => 'alamat',
            'postal_code' => 'kode pos',
            'is_active' => 'status aktif',
            'letterhead' => 'kop surat'
        ];
    }
}
