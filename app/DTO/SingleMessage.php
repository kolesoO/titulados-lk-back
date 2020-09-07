<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Contracts\Support\Arrayable;

class SingleMessage implements Arrayable
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function toArray()
    {
        return [
            'message' => $this->message,
        ];
    }
}
