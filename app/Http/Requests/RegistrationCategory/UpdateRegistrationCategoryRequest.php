<?php

namespace App\Http\Requests\RegistrationCategory;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateRegistrationCategoryRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:registration_categories,name,' . $this->route('registrationCategory')->slug . ',slug'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
