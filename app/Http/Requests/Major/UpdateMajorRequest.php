<?php

namespace App\Http\Requests\Major;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMajorRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'is_active' => ['required', 'boolean']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'is_active' => 'status aktif',
        ];
    }
}
