<?php

declare(strict_types=1);

namespace App\Http\Requests;

class LoginRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }
}
