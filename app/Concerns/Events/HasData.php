<?php

declare(strict_types=1);

namespace App\Concerns\Events;

trait HasData
{
    protected array $data = [];

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
