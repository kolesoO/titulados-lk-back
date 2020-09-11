<?php

declare(strict_types=1);

namespace App\DTO\User;

use Illuminate\Contracts\Support\Arrayable;

class Settings implements Arrayable
{
    private bool $sendNewOrdersInfo;

    private bool $dontCall;

    private array $facultyIds;

    public function __construct(array $settings)
    {
        $this->sendNewOrdersInfo = (bool) ($settings['send_new_orders_info'] ?? false);
        $this->dontCall = (bool) ($settings['dont_call'] ?? false);
        $this->facultyIds = (array) ($settings['faculties'] ?? []);
    }

    /** @inheritDoc */
    public function toArray()
    {
        $result = [];

        foreach ($this->getArray() as $code => $value) {
            $result[$code] = [
                'code' => $code,
                'value' => $value,
                'caption' => trans('user.settings.' . $code),
            ];
        }

        return $result;
    }

    public function getValue(): string
    {
        return json_encode($this->getArray());
    }

    public function getFacultyIds(): array
    {
        return $this->facultyIds;
    }

    public function setFacultyIds(array $ids): self
    {
        $this->facultyIds = $ids;

        return $this;
    }

    public function getArray(): array
    {
        return [
            'send_new_orders_info' => $this->sendNewOrdersInfo,
            'dont_call' => $this->dontCall,
            'faculties' => $this->facultyIds,
        ];
    }
}
