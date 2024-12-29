<?php

namespace App\Http\Requests\Role;

use App\Rules\Role\NameRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', new NameRule($this->route('role')->slug)],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'permissions' => 'hak akses',
        ];
    }
}
