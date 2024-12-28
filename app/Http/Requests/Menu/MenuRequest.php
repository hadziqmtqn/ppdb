<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'type' => ['required', 'in:"main_menu","sub_menu"'],
            'main_menu' => ['required_if:type,"sub_menu"', 'nullable'],
            'visibility' => ['required', 'array'],
            'visibility.*' => ['required', 'exists:permissions,name'],
            'url' => ['required'],
            'icon' => ['nullable'],
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
            'type' => 'jenis',
            'main_menu' => 'menu utama',
            'visibility' => 'hak akses',
            'visibility.*' => 'hak akses',
            'url' => 'url',
            'icon' => 'ikon',
        ];
    }
}
