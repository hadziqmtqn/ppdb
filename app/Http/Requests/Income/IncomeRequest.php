<?php

namespace App\Http\Requests\Income;

use Illuminate\Foundation\Http\FormRequest;

class IncomeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'nominal' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
