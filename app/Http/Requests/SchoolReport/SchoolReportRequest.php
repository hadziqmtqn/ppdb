<?php

namespace App\Http\Requests\SchoolReport;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class SchoolReportRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'lesson_id' => ['required', 'integer', 'exists:lessons,id'],
            'score' => ['required', 'numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'lesson_id' => 'mata pelajaran',
            'score' => 'nilai',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors()->first(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
