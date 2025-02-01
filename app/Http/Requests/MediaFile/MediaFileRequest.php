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
            'create_new' => ['required', 'in:YA,TIDAK'],
            'name' => ['required_if:create_new,YA', 'nullable'],
            'media_file_id' => ['required_if:create_new,TIDAK', 'nullable'],
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'registration_path_id' => ['nullable', 'integer', 'exists:registration_paths,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required_if' => ':attribute wajib diisi tambah baru',
            'media_file_id.required_if' => ':attribute wajib diisi tambah baru',
        ];
    }

    public function attributes(): array
    {
        return [
            'create_new' => 'tambah baru',
            'name' => 'nama file baru',
            'media_file_id' => 'media file',
            'educational_institution_id' => 'lembaga',
            'registration_path_id' => 'jalur pendaftaran',
        ];
    }
}
