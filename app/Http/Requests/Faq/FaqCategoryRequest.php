<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class FaqCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slugs' => ['required', 'array'],
            'slugs.*' => ['required', 'exists:faq_categories,slug'],
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string'],
            'qualification' => ['required', 'array'],
            'qualification.*' => ['required', 'array'],
            'qualification.*.*' => ['required', 'integer', 'exists:educational_institutions,id'],
            'new_faq_category_name' => ['nullable'],
            'new_qualification' => ['nullable', 'array'],
            'new_qualification.*' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'slugs' => 'id',
            'slugs.*' => 'id',
            'name' => 'nama',
            'name.*' => 'nama',
            'qualification' => 'kualifikasi',
            'qualification.*' => 'kualifikasi',
            'qualification.*.*' => 'kualifikasi',
            'new_faq_category_name' => 'kategori baru',
            'new_qualification' => 'kualifikasi baru',
            'new_qualification.*' => 'kualifikasi baru',
        ];
    }
}