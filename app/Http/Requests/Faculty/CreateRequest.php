<?php

declare(strict_types=1);

namespace App\Http\Requests\Faculty;

use App\Http\Requests\Request;

class CreateRequest extends Request
{
    public function rules(): array
    {
        return [
            'caption' => 'required',
        ];
    }
}
