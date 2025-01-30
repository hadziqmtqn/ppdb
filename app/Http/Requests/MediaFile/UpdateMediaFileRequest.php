<?php

namespace App\Http\Requests\MediaFile;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaFileRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'category' => ['required', 'in:"semua_unit","unit_tertentu"'],
            'educational_institutions' => ['required_if:category,unit_tertentu', 'nullable', 'array'],
            'educational_institutions.*' => ['required_if:category,unit_tertentu', 'nullable', 'integer', 'exists:educational_institutions,id'],
            'is_active' => ['required', 'boolean']
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
            'is_active' => 'status aktif'
        ];
    }
}
