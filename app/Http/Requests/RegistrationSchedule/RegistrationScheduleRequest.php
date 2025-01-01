<?php

namespace App\Http\Requests\RegistrationSchedule;

use App\Rules\RegistrationSchedule\EducationalInstitutionRule;
use App\Rules\RegistrationSchedule\SchoolYearRule;
use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class RegistrationScheduleRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id', new EducationalInstitutionRule($this->input('educational_institution_id'), $this->input('school_year_id'))],
            'school_year_id' => ['required', 'integer', 'exists:school_years,id', new SchoolYearRule($this->input('educational_institution_id'), $this->input('school_year_id'))],
            'start_date' => ['required', 'date', 'date_format:Y-m-d', 'before:end_date', 'after:today'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after:start_date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'start_date.after' => ':attribute harus berisi tanggal setelah hari ini.'
        ];
    }

    public function attributes(): array
    {
        return [
            'educational_institution_id' => 'lembaga',
            'school_year_id' => 'tahun ajaran',
            'start_date' => 'tanggal mulai',
            'end_date' => 'tanggal berakhir',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
