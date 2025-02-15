<?php

namespace App\Http\Requests\Messages;

use Illuminate\Foundation\Http\FormRequest;

class ConversationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'user_id' => ['required', 'integer'],
            'admin_id' => ['nullable', 'integer'],
            'subject' => ['required'],
            'message' => ['required'],
            'is_seen' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
