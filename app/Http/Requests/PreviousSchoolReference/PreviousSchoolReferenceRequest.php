<?php

namespace App\Http\Requests\PreviousSchoolReference;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class PreviousSchoolReferenceRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'educational_group_id' => ['required', 'integer', 'exists:educational_groups,id'],
            'npsn' => ['nullable', 'digits:8'],
            'name' => ['required'],
            'province' => ['required'],
            'city' => ['required'],
            'district' => ['required'],
            'village' => ['required'],
            'street' => ['nullable'],
            'status' => ['required', 'in:"Swasta","Negeri"'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'educational_group_id' => 'kelompok pendidikan',
            'name' => 'nama',
            'province' => 'provinsi',
            'city' => 'kota/kabupaten',
            'district' => 'kecamatan',
            'village' => 'desa/kelurahan',
            'street' => 'jalan',
            'status' => 'status sekolah',
        ];
    }
}
