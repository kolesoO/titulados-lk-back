<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ReflectionClass;
use ReflectionException;

abstract class Base
{
    protected string $modelClass;

    /** @var Model */
    protected $modelInstance;

    /**
     * @throws ReflectionException
     */
    public function __construct()
    {
        $reflection = new ReflectionClass($this->modelClass);
        $this->modelInstance = $reflection->newInstance();
    }

    public function newQuery(): Builder
    {
        return $this->modelInstance->newQuery();
    }

    public function find(int $id): ?Model
    {
        return $this->newQuery()->find($id);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Model
    {
        return $this->newQuery()->findOrFail($id);
    }
}
