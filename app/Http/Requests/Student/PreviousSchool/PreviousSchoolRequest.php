<?php

namespace App\Http\Requests\Student\PreviousSchool;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class PreviousSchoolRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'school_name' => ['required'],
            'status' => ['required', 'in:"Swasta","Negeri"'],
            'province' => ['nullable'],
            'city' => ['nullable'],
            'district' => ['nullable'],
            'village' => ['nullable'],
            'street' => ['nullable']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'school_name' => 'nama asal sekolah',
            'status' => 'status',
            'address' => 'alamat',
            'province' => 'provinsi',
            'city' => 'kota/kabupaten',
            'district' => 'kecamatan',
            'village' =>'desa/kelurahan',
            'street' => 'jalan'
        ];
    }
}
