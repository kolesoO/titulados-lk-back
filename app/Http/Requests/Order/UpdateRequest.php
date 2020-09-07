<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'deadline' => 'required|string',
            'name' => 'required|string',
            'course' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
            'attachment' => 'max:5',
            'attachment.*' => 'max:3024',
        ];
    }
}
