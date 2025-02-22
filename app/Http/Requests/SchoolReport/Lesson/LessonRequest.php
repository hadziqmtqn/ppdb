<?php

namespace App\Http\Requests\SchoolReport\Lesson;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'code' => ['required', 'unique:lessons,code'],
            'name' => ['required'],
            'type' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'code' => 'kode',
            'name' => 'nama',
            'type' => 'tipe mapel',
        ];
    }
}
