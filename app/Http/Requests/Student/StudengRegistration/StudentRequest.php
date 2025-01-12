<?php

namespace App\Http\Requests\Student\StudengRegistration;

use App\Rules\Student\StudentRegistration\NisnRule;
use App\Rules\Student\StudentRegistration\WhatsappNumberRule;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class StudentRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'registration_category_id' => ['required', 'integer', 'exists:registration_categories,id'],
            'has_registration_path' => ['required', 'in:YES,NO'],
            'registration_path_id' => ['required_if:has_registration_path,YES', 'nullable', 'integer', 'exists:registration_paths,id'],
            'class_level_id' => ['required', 'integer', 'exists:class_levels,id'],
            'has_major' => ['required', 'in:YES,NO'],
            'major_id' => ['required_if:has_major,YES', 'nullable', 'integer', 'exists:majors,id'],
            'nisn_is_required' => ['required', 'in:YES,NO'],
            'nisn' => ['required_if:nisn_is_required,YES', 'nullable', 'digits:10', new NisnRule($this->route('user')->username)],
            'name' => ['required', 'string', 'min:3'],
            'whatsapp_number' => ['required', 'numeric', 'min_digits:10', 'max_digits:13', new WhatsappNumberRule($this->route('user')->username)],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'registration_path_id.required_if' => ':attribute wajib diisi',
            'major_id.required_if' => ':attribute wajib diisi',
            'nisn.required_if' => ':attribute wajib diisi',
        ];
    }

    public function attributes(): array
    {
        return [
            'registration_category_id' => 'kategori pendaftaran',
            'registration_path_id' => 'jalur pendaftaran',
            'class_level_id' => 'kelas',
            'major_id' => 'jurusan',
            'nisn' => 'NISN',
            'name' => 'nama lengkap',
            'whatsapp_number' => 'nomor whatsapp',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
