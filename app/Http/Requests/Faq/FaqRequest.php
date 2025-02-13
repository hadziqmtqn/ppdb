<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'faq_category_id' => ['nullable', 'integer'],
            'title' => ['required'],
            'description' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
