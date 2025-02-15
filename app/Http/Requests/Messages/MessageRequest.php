<?php

namespace App\Http\Requests\Messages;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug' => ['required'],
            'conversation_id' => ['required', 'integer'],
            'user_id' => ['required', 'integer'],
            'message' => ['required'],
            'is_seen' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
