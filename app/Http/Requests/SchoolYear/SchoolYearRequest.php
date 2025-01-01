<?php

namespace App\Http\Requests\SchoolYear;

use Illuminate\Foundation\Http\FormRequest;

class SchoolYearRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_year' => ['required', 'date_format:Y', 'before:last_year', 'unique:school_years,first_year'],
            'last_year' => ['required', 'date_format:Y', 'after:first_year', 'unique:school_years,last_year'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'first_year' => 'tahun awal',
            'last_year' => 'tahun akhir',
            'is_active' => 'status aktif'
        ];
    }
}
