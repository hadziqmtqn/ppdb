<?php

namespace App\Http\Requests\WhatsappConfig;

use Illuminate\Foundation\Http\FormRequest;

class WhatsappConfigRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'domain' => ['required'],
            'api_key' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
