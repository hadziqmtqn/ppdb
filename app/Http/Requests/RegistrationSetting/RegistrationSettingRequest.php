<?php

namespace App\Http\Requests\RegistrationSetting;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationSettingRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'accepted_with_school_report' => ['required', 'boolean'],
            'school_report_semester' => ['required_if:accepted_with_school_report,1', 'array'],
            'school_report_semester.*' => ['required_if:accepted_with_school_report,1', 'integer']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'school_report_semester.required_if' => ':attribute wajib diisi jika diterima dengan nilai raport',
            'school_report_semester.*.required_if' => ':attribute wajib diisi jika diterima dengan nilai raport'
        ];
    }

    public function attributes(): array
    {
        return [
            'educational_institution_id' => 'lembaga',
            'accepted_with_school_report' => 'diterima dengan nilai rapor',
            'school_report_semester' => 'rapor semester',
            'school_report_semester.*' => 'rapor semester'
        ];
    }
}
