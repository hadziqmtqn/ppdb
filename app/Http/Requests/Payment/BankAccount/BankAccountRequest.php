<?php

namespace App\Http\Requests\Payment\BankAccount;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'payment_channel_id' => ['required', 'integer', 'exists:payment_channels,id'],
            'account_name' => ['required'],
            'account_number' => ['required'],
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
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
            'payment_channel_id' => 'saluran pembayaran',
            'account_name' => 'nama pemilik',
            'account_number' => 'nomor rekening',
            'educational_institution_id' => 'lembaga pendidikan',
            'is_active' => 'status',
        ];
    }
}
