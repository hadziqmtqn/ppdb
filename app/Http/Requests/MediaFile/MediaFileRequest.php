<?php

namespace App\Http\Requests\MediaFile;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class MediaFileRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'category' => ['required', 'in:"semua_unit","unit_tertentu"'],
            'educational_institutions' => ['required_if:category,unit_tertentu', 'nullable', 'array'],
            'educational_institutions.*' => ['required_if:category,unit_tertentu', 'nullable', 'integer', 'exists:educational_institutions,id'],
            'registration_paths' => ['nullable', 'array'],
            'registration_paths.*' => ['nullable', 'string', 'exists:registration_path,code'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'educational_institutions.required_if' => ':attribute wajib diisi jika kategori unit tertentu',
            'educational_institutions.*.required_if' => ':attribute wajib diisi jika kategori unit tertentu',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama file',
            'category' => 'kategori',
            'educational_institutions' => 'lembaga pendidikan',
            'educational_institutions.*' => 'lembaga pendidikan',
            'registration_paths' => 'jalur pendaftaran',
            'registration_paths.*' => 'jalur pendaftaran',
        ];
    }
}
