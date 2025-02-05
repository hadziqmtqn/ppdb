<?php

namespace App\Http\Requests\Payment\RegistrationFee;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationFeeRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'type_of_payment' => ['required', 'in:"sekali_bayar","kredit"'],
            'registration_status' => ['required', 'in:"siswa_belum_diterima","siswa_diterima"'],
            'name' => ['required'],
            'amount' => ['required', 'numeric'],
            'is_active' => ['required', 'boolean']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'type_of_payment' => 'jenis pembayaran',
            'registration_status' => 'status registrasi',
            'name' => 'nama',
            'amount' => 'jumlah',
            'is_active' => 'status aktif'
        ];
    }
}
