<?php

namespace App\Http\Requests\Messages;

use App\Traits\ApiResponse;
use App\Traits\HandlesValidationFailure;
use Illuminate\Foundation\Http\FormRequest;

class ConversationRequest extends FormRequest
{
    use ApiResponse, HandlesValidationFailure;

    public function rules(): array
    {
        return [
            'send_to' => ['required', 'in:user,admin'],
            'user_id' => ['required_if:send_to,user', 'nullable', 'integer', 'exists:users,id'],
            'subject' => ['required'],
            'message' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'user_id.required_if' => ':attribute wajib diisi jika kirim ke Siswa'
        ];
    }

    public function attributes(): array
    {
        return [
            'send_to' => 'kirim ke',
            'user_id' => 'siswa',
            'subject' => 'subjek',
            'message' => 'pesan',
        ];
    }
}
