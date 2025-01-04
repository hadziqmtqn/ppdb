<?php

namespace App\Http\Requests\RegistrationPath;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateRegistrationPathRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:registration_paths,name,' . $this->route('registrationPath')->slug . ',slug'],
            'is_active' => ['required', 'boolean']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'is_active' => 'status aktif'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
