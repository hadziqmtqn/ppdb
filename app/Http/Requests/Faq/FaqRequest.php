<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'faq_category_id' => ['required', 'integer', 'exists:faq_categories,id'],
            'educational_institution_id' => ['nullable', 'integer', 'exists:educational_institutions,id'],
            'title' => ['required'],
            'description' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'faq_category_id' => 'kategori pertanyaan',
            'educational_institution_id' => 'lembaga pendidikan',
            'title' => 'judul',
            'description' => 'deskripsi',
        ];
    }
}
