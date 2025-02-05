<?php

namespace App\Http\Requests\Payment\PaymentSetting;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class PaymentSettingRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
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
            'educational_institution_id' => 'lembaga',
            'payment_method' => 'metode pembayaran'
        ];
    }
}
