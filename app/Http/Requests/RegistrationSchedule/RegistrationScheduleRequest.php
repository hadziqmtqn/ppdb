<?php

namespace App\Http\Requests\RegistrationSchedule;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationScheduleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'school_year_id' => ['required', 'integer', 'exists:school_years,id'],
            'start_date' => ['required', 'date', 'date_format:Y-m-d', 'before:end_date'],
            'end_date' => ['required', 'date', 'date_format:Y-m-d', 'after:start_date'],
        ];
    }

    public function authorize(): bool
    {
        return true;
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
}
