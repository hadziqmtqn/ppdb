<?php

namespace App\Http\Requests\Payment\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSettingRequest extends FormRequest
{
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
