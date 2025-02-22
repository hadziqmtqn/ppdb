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
            'create_new' => ['required', 'boolean'],
            'previous_school_reference_id' => ['required_if:create_new,0', 'nullable', 'integer', 'exists:previous_school_references,id'],
            'school_name' => ['required_if:create_new,1', 'nullable'],
            'educational_group_id' => ['required_if:create_new,1', 'nullable', 'integer', 'exists:educational_groups,id'],
            'status' => ['required_if:create_new,1', 'integer', 'in:"Swasta","Negeri"'],
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

    public function messages(): array
    {
        return [
            'previous_school_reference_id' => ':attribute wajib diisi jika tidak tambah baru',
            'school_name' => ':attribute wajib diisi jika tambah baru',
            'educational_group_id' => ':attribute wajib diisi jika tambah baru',
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
