<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderPart;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderPartRepository extends Base
{
    protected string $modelClass = OrderPart::class;

    public function create(Order $order, array $attributes = []): OrderPart
    {
        $entity = new OrderPart($attributes);
        $entity->status = OrderPart::NEW_STATUS;
        $entity->order()->associate($order);

        return $entity;
    }

    public function save(OrderPart $entity, array $options = []): bool
    {
        return $entity->save($options);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByIdForOrder(int $id, Order $order): OrderPart
    {
        $result = $order->parts()->findOrFail($id);

        return $result;
    }
}
