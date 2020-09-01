<?php

declare(strict_types=1);

namespace App\Casts\User;

use App\DTO\User\Settings as SettingsDTO;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class Settings implements CastsAttributes
{
    /** @inheritDoc */
    public function get($model, string $key, $value, array $attributes)
    {
        return new SettingsDTO(
            json_decode($value, true)
        );
    }

    /** @inheritDoc */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof SettingsDTO) {
            throw new InvalidArgumentException('The given value is not an ' . SettingsDTO::class . ' instance');
        }

        return $value->getValue();
    }
}
