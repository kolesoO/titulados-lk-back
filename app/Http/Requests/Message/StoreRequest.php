<?php

declare(strict_types=1);

namespace App\Http\Requests\Message;

use App\Http\Requests\Request;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'text' => 'required|string',
        ];
    }
}
