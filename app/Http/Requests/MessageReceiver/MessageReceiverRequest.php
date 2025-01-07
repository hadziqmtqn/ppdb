<?php

namespace App\Http\Requests\MessageReceiver;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class MessageReceiverRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'message_template_id' => ['required', 'integer', 'exists:message_templates,id'],
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
            'educational_institution_id' => 'lembaga',
            'message_template_id' => 'templat pesan',
            'user_id' => 'penerima'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
