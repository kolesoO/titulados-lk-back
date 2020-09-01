<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Models\HasUserType;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderRepository extends Base
{
    protected string $modelClass = Order::class;

    public function createModel(Model $user, array $attributes = []): Order
    {
        $entity = new Order($attributes);
        $entity->student()->associate($user);

        return $entity;
    }

    /**
     * @return Collection|Order[]
     */
    public function getForUser(HasUserType $user): Collection
    {
        return $user->orders()->get();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByIdForUser(int $id, HasUserType $user): Order
    {
        /** @var Order $result */
        $result = $user->orders()->findOrFail($id);

        return $result;
    }

    public function save(Order $entity, array $options = []): bool
    {
        return $entity->save($options);
    }

    public function update(Order $entity, array $attributes = [], array $options = []): bool
    {
        return $entity->update($attributes, $options);
    }
}
