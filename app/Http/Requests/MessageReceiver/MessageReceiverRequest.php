<?php

namespace App\Http\Requests\MessageReceiver;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class MessageReceiverRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

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
}
