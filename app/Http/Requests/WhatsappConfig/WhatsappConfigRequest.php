<?php

namespace App\Http\Requests\WhatsappConfig;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class WhatsappConfigRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'domain' => ['required'],
            'api_key' => ['required'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'is_active' => 'status aktif'
        ];
    }
}
