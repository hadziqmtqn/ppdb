<?php

namespace App\Http\Requests\EducationalLevel;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class EducationalLevelRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:educational_levels,name,' . $this->route('educationalLevel')->slug . ',slug'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors()->first(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
