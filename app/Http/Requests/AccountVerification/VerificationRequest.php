<?php

namespace App\Http\Requests\AccountVerification;

use Illuminate\Foundation\Http\FormRequest;

class VerificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => ['required']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
