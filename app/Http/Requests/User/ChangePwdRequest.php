<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class ChangePwdRequest extends Request
{
    public function rules(): array
    {
        return [
            'password' => 'required|string',
        ];
    }
}
