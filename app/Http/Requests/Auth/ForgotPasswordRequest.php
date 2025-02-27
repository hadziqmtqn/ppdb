<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'send_token_to' => ['required', 'in:email,whatsapp']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'send_token_to' => 'kirim token ke'
        ];
    }
}
