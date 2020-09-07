<?php

declare(strict_types=1);

namespace App\Models;
use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    /** @var array */
    protected $filterable = [];

    public function getFilterable(): array
    {
        return $this->filterable;
    }
}
