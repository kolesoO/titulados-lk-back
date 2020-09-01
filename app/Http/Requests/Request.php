<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

abstract class Request extends FormRequest
{
    /**
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors): JsonResponse
    {
        return (new JsonResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY));
    }


    /**
     * {@inheritdoc}
     */
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException(
            $validator,
            (new JsonResponse($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY))
        ))
            ->errorBag($this->errorBag)
            ->redirectTo(
                $this->getRedirectUrl()
            );
    }
}
