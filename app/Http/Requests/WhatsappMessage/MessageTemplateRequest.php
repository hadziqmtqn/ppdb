<?php

namespace App\Http\Requests\WhatsappMessage;

use Illuminate\Foundation\Http\FormRequest;

class MessageTemplateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'category' => ['required'],
            'message' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'title' => 'judul',
            'educational_institution_id' => 'lembaga',
            'category' => 'kategori',
            'message' => 'pesan',
        ];
    }
}
