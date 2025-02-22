<?php

namespace App\Http\Requests\SchoolReport\Lesson;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'code' => ['required', 'unique:lessons,code,' . $this->route('lesson')->slug . ',slug'],
            'name' => ['required'],
            'type' => ['required'],
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
            'code' => 'kode',
            'name' => 'nama',
            'type' => 'tipe mapel',
            'is_active' => 'status aktif'
        ];
    }
}
