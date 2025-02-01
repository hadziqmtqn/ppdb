<?php

namespace App\Http\Requests\MediaFile;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class DetailMediaFileRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'is_active' => ['required', 'boolean'],
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'registration_path_id' => ['nullable', 'integer', 'exists:registration_paths,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama file',
            'is_active' => 'status aktif',
            'educational_institution_id' => 'lembaga',
            'registration_path_id' => 'jalur pendaftaran',
        ];
    }
}
