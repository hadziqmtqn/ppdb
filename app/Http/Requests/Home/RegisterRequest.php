<?php

namespace App\Http\Requests\Home;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'registration_category_id' => ['required', 'integer', 'exists:registration_categories,id'],
            'has_registration_path' => ['required', 'in:YES,NO'],
            'registration_path_id' => ['required_if:has_registration_path,YES', 'nullable', 'integer', 'exists:registration_paths,id'],
            'class_level_id' => ['required', 'integer', 'exists:class_levels,id'],
            'has_major' => ['required', 'in:YES,NO'],
            'major_id' => ['required_if:has_major,YES', 'nullable', 'integer', 'exists:majors,id'],
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'unique:users,email'],
            'whatsapp_number' => ['required', 'numeric', 'unique:students,whatsapp_number', 'min_digits:10', 'max_digits:13'],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'password_confirmation' => ['required', 'same:password']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'registration_path_id.required_if' => ':attribute wajib diisi jika lembaga memiliki jalur pendaftaran',
            'major_id.required_if' => ':attribute wajib diisi jika lembaga memiliki jurusan',
            'password.regex' => ':attribute minimal terdiri dari angka, 1 huruf besar, huruf kecil, dan karakter khusus',
        ];
    }

    public function attributes(): array
    {
        return [
            'educational_institution_id' => 'lembaga',
            'registration_category_id' => 'kategori pendaftaran',
            'registration_path_id' => 'jalur pendaftaran',
            'class_level_id' => 'kelas',
            'major_id' => 'jurusan',
            'name' => 'nama lengkap',
            'email' => 'email',
            'whatsapp_number' => 'nomor whatsapp',
            'password' => 'kata sandi',
            'password_confirmation' => 'konfirmasi kata sandi'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
