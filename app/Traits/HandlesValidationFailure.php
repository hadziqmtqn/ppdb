<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

trait HandlesValidationFailure
{
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiResponse($validator->errors(), null, null, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
