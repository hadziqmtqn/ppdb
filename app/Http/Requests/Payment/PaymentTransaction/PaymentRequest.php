<?php

namespace App\Http\Requests\Payment\PaymentTransaction;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric'],
            'link_checkout' => ['nullable'],
            'status' => ['required'],
            'payment_method' => ['required'],
            'payment_channel' => ['nullable'],
            'bank_account_id' => ['nullable', 'integer'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
