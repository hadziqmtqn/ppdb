<?php

namespace App\Http\Requests\Faq;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FilterRequest extends FormRequest
{
    use ApiResponse;

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'min:3'],
            'faq_category_id' => ['required', 'integer', 'exists:faq_categories,id'],
            'educational_institution_id' => ['nullable', 'integer', 'exists:educational_institutions,id']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes(): array
    {
        return [
            'search' => 'pencarian',
            'faq_category_id' => 'kategori',
            'educational_institution_id' => 'lembaga'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors()->first(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
