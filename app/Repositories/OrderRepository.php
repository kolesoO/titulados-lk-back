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
        $entity->status = Order::NEW_STATUS;
        $entity->student()->associate($user);

        return $entity;
    }

    /**
     * @return Collection|Order[]
     */
    public function getForUser(HasUserType $user, array $filter = []): Collection
    {
        $builder = $user->orders()->getQuery();

        return $this->getQueryByFilter($builder, $filter)->get();
    }

    /**
     * @return Collection|Order[]
     */
    public function getAvailableForUser(HasUserType $user, array $filter = []): Collection
    {
        if ($user->availableOrdersForeignKey()) {
            $builder = Order::query()
                ->whereNull(
                    $user->availableOrdersForeignKey()
                );

            return $this->getQueryByFilter($builder, $filter)->get();
        }

        return Collection::make([]);
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

    public function findByIdForUser(int $id, HasUserType $user): ?Order
    {
        /** @var Order|null $result */
        $result = $user->orders()->find($id);

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
