<?php

namespace App\Http\Requests\MediaFile;

use Illuminate\Foundation\Http\FormRequest;

class DetailMediaFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'media_file_id' => ['required', 'integer'],
            'educational_institution_id' => ['required', 'integer'],
            'registration_path_id' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
