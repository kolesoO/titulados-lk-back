<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Str;

class Tokenizer
{
    protected string $token;

    protected string $hash;

    public function __construct(int $length = 60)
    {
        $this->token = Str::random($length);
        $this->hash = hash('sha256', $this->token);
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
