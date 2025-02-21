<?php

namespace App\Http\Requests\SchoolReport;

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
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'educational_group_id' => ['required', 'integer', 'exists:educational_groups,id']
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
            'educational_group_id' => 'asal kelompok pendidikan'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors()->first(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
