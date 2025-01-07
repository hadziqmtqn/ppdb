<?php

namespace App\Http\Requests\MessageReceiver;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class UpdateMessageReceiverRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'user_id' => 'penerima'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
