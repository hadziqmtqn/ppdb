<?php

namespace App\Http\Requests\Payment\PaymentMethod;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class PaymentSettingRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'payment_method' => ['required', 'in:"MANUAL_PAYMENT","PAYMENT_GATEWAY"'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'payment_method' => 'metode pembayaran'
        ];
    }
}
