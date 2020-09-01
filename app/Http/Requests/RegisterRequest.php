<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'phone' => 'required',
            'surname' => 'string',
            'name' => 'required|string',
            'last_name' => 'string',
            //'city' => '',
            'password' => 'required',
            'type' => [
                'required',
                Rule::in([
                    User::STUDENT_TYPE,
                    User::TEACHER_TYPE,
                ])
            ]
        ];
    }
}
