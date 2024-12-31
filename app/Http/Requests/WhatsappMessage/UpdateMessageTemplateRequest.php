<?php

namespace App\Http\Requests\WhatsappMessage;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMessageTemplateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'educational_institution_id' => ['required', 'integer', 'exists:educational_institutions,id'],
            'category' => ['required'],
            'recipient' => ['required', 'in:super-admin,admin,user'],
            'message' => ['required'],
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
            'title' => 'judul',
            'educational_institution_id' => 'lembaga',
            'category' => 'kategori',
            'recipient' => 'penerima',
            'message' => 'pesan',
            'is_active' => 'status aktif',
        ];
    }
}
