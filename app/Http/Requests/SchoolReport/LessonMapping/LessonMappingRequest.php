<?php

namespace App\Http\Requests\SchoolReport\LessonMapping;

use Illuminate\Foundation\Http\FormRequest;

class LessonMappingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'lesson_id' => ['required', 'integer', 'exists:lessons,id'],
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'previous_educational_group' => ['required', 'array'],
            'previous_educational_group.*' => ['required', 'integer', 'exists:educational_groups,id'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'lesson_id' => 'mata pelajaran',
            'educational_institution_id' => 'lembaga',
            'previous_educational_group' => 'kelompok pendidikan sebelumnya',
            'previous_educational_group.*' => 'kelompok pendidikan sebelumnya',
        ];
    }
}
