<?php

namespace App\Http\Requests\Student\FileUploading;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class FileUploadingRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'file_name' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
