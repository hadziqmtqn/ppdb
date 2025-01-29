<?php

namespace App\Http\Requests\Income;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

class IncomeRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'nominal' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
