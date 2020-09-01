<?php

declare(strict_types=1);

namespace App\Http\Requests\OrderDoc;

use App\Http\Requests\Request;

class StoreRequest extends Request
{
    public function rules(): array
    {
        return [
            'comment' => 'string',
            'attachment' => 'required|max:3024',
        ];
    }
}
