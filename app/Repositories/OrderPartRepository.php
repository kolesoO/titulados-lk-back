<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderPart;
use Illuminate\Database\Eloquent\Collection;
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
    public function getFirstForOrder(Order $order): OrderPart
    {
        /** @var OrderPart $result */
        $result = $order->parts()->firstOrFail();

        return $result;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByIdForOrder(int $id, Order $order): OrderPart
    {
        /** @var OrderPart $result */
        $result = $order->parts()->findOrFail($id);

        return $result;
    }

    public function getPreviousForOrder(OrderPart $orderPart, Order $order): Collection
    {
        return $order->parts()
            ->where('id', '<', $orderPart->id)
            ->get();
    }

    public function getNextForOrder(OrderPart $orderPart, Order $order): Collection
    {
        return $order->parts()
            ->where('id', '>', $orderPart->id)
            ->get();
    }
}
