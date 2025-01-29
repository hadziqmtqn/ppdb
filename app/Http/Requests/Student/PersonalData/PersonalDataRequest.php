<?php

namespace App\Http\Requests\Student\PersonalData;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class PersonalDataRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'place_of_birth' => ['required'],
            'data_of_birth' => ['required', 'date', 'date_format:Y-m-d', 'before:today'],
            'gender' => ['required'],
            'child_to' => ['required', 'integer', 'min:1'],
            'number_of_brothers' => ['required', 'integer', 'min:1', 'gte:child_to'],
            'family_relationship' => ['required'],
            'religion' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'date_of_birth.before' => ':attribute sebelum tanggal hari ini'
        ];
    }

    public function attributes(): array
    {
        return [
            'place_of_birth' => 'tempat lahir',
            'data_of_birth' => 'tanggal lahir',
            'gender' => 'jenis kelamin',
            'child_to' => 'anak ke',
            'number_of_brothers' => 'jumlah saudara kandung',
            'family_relationship' => 'hubungan keluarga',
            'religion' => 'agama',
        ];
    }
}
