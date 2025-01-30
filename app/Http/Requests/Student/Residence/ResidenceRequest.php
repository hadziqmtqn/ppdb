<?php

namespace App\Http\Requests\Student\Residence;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class ResidenceRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'province' => ['required'],
            'city' => ['required'],
            'district' => ['required'],
            'village' => ['required'],
            'street' => ['required'],
            'postal_code' => ['required', 'digits:5'],
            'distance_to_school_id' => ['required', 'integer', 'exists:distance_to_schools,id'],
            'transportation_id' => ['required', 'integer', 'exists:transportations,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'province' => 'provinsi',
            'city' => 'kota/kabupaten',
            'district' => 'kecamatan',
            'village' => 'desa/kelurahan',
            'street' => 'jalan',
            'postal_code' => 'kode pos',
            'distance_to_school_id' => 'jarak ke sekolah',
            'transportation_id' => 'transportasi',
        ];
    }
}
