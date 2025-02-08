<?php

namespace App\Http\Requests\Payment\PaymentTransaction;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class PaymentValidationRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:"PAID","CANCEL"']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
