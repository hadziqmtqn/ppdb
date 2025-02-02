<?php

namespace App\Http\Requests\Student;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FilterRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'school_year_id' => ['required', 'integer', 'exists:school_years,id'],
            'educational_institution_id' => ['nullable', 'integer', 'exists:educational_institutions,id'],
            'registration_category_id' => ['nullable', 'integer', 'exists:registration_categories,id'],
            'registration_path_id' => ['nullable', 'integer', 'exists:registration_paths,id'],
            'registration_status' => ['nullable', 'in:"belum_diterima","diterima","ditolak"'],
            'status' => ['nullable', 'in:"active","inactive","deleted"']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'school_year_id' => 'tahun ajaran',
            'educational_institution_id' => 'lembaga',
            'registration_category_id' => 'kategori',
            'registration_path_id' => 'jalur pendaftaran',
            'registration_status' => 'status pendaftaran',
            'status' => 'status akun'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors()->first(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
