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
            'educational_group_id' => ['required', 'integer', 'exists:educational_groups,id'],
            'province' => ['required'],
            'city' => ['required'],
            'district' => ['required'],
            'village' => ['nullable'],
            'street' => ['nullable'],
            'previous_school_reference_id' => ['required_if:create_new,0', 'nullable', 'integer', 'exists:previous_school_references,id'],
            'create_new' => ['required', 'boolean'],
            'school_name' => ['required_if:create_new,1', 'nullable'],
            'status' => ['required_if:create_new,1', 'integer', 'in:"Swasta","Negeri"'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'educational_group_id' => ':attribute wajib diisi jika tambah baru',
            'previous_school_reference_id' => ':attribute wajib diisi jika tidak tambah baru',
            'school_name' => ':attribute wajib diisi jika tambah baru',
            'status' => ':attribute wajib diisi jika tambah baru'
        ];
    }

    public function attributes(): array
    {
        return [
            'create_new' => 'tambah baru',
            'school_name' => 'nama asal sekolah',
            'educational_group_id' => 'kelompok pendidikan',
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
