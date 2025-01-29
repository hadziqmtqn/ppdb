<?php

namespace App\Http\Requests\DistanceToSchool;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class DistanceToSchoolRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'name' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
