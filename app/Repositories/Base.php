<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ReflectionClass;
use ReflectionException;

abstract class Base
{
    protected string $modelClass;

    /** @var BaseModel */
    protected $modelInstance;

    /**
     * @throws ReflectionException
     */
    public function __construct()
    {
        $reflection = new ReflectionClass($this->modelClass);
        $this->modelInstance = $reflection->newInstance();
    }

    public function getModelInstance(): BaseModel
    {
        return $this->modelInstance;
    }

    public function newQuery(): Builder
    {
        return $this->modelInstance->newQuery();
    }

    public function find(int $id): ?BaseModel
    {
        return $this->newQuery()->find($id);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getById(int $id): BaseModel
    {
        return $this->newQuery()->findOrFail($id);
    }

    public function getQueryByFilter(Builder $builder, array $filter = []): Builder
    {
        if (!$this->modelInstance instanceof Model) {
            return $builder;
        }

        foreach ($filter as $key => $value) {
            if (!in_array($key, $this->modelInstance->getFilterable())) {
                continue;
            }

            if (is_array($value)) {
                $builder->whereIn($key, $value);

                continue;
            }

            $builder->where($key, $value);
        }

        return $builder;
    }
}
