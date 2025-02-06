<?php

namespace App\Http\Requests\Payment\PaymentTransaction;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class PaymentRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'pay_method' => ['required', 'in:"MANUAL_PAYMENT","PAYMENT_GATEWAY"'],
            'registration_fee_id' => ['required', 'array'],
            'registration_fee_id.*' => ['required', 'integer', 'exists:registration_fees,id'],
            'paid_amount' => ['required', 'array'],
            'paid_amount.*' => ['required', 'numeric'],
            'bank_account_id' => ['required_if:pay_method,MANUAL_PAYMENT', 'nullable', 'integer', 'exists:bank_accounts,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'pay_method' => 'metode bayar',
            'registration_fee_id' => 'biaya pendaftaran',
            'registration_fee_id.*' => 'biaya pendaftaran',
            'paid_amount' => 'jumlah bayar',
            'paid_amount.*' => 'jumlah bayar',
            'bank_account_id' => 'rekening bank tujuan'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors()->first(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
