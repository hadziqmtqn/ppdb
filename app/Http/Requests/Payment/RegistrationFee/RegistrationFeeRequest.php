<?php

namespace App\Http\Requests\Payment\RegistrationFee;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationFeeRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'school_year_id' => ['required', 'integer', 'exists:school_years,id'],
            'type_of_payment' => ['required', 'in:"sekali_bayar","kredit"'],
            'registration_status' => ['required', 'in:"siswa_belum_diterima","siswa_diterima"'],
            'name' => ['required'],
            'amount' => ['required', 'numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
