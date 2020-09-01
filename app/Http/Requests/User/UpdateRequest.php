<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'settings' => 'array|min:1',
        ];
    }
}
