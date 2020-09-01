<?php

declare(strict_types=1);

namespace App\DTO\User;

class ModelAttributes
{
    private Settings $settings;

    private string $password;

    private array $other;

    public function __construct(array $other)
    {
        $this->other = $other;
    }

    public function getSettings(): ?Settings
    {
        return $this->settings;
    }

    public function setSettings(Settings $settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getOther(): array
    {
        return $this->other;
    }

    public function toArray(): array
    {
        return array_merge(
            $this->other,
            [
                'settings' => $this->settings->toArray(),
                'password' => $this->password,
            ]
        );
    }
}
