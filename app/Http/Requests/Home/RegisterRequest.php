<?php

namespace App\Http\Requests\Home;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'registration_category_id' => ['required', 'integer', 'exists:registration_categories,id']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
