<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\File;
use App\Models\Order;
use App\Models\OrderDoc;
use Illuminate\Database\Eloquent\Collection;

class OrderDocRepository extends Base
{
    protected string $modelClass = OrderDoc::class;

    public function create(File $file, Order $order): OrderDoc
    {
        $entity = new OrderDoc();
        $entity->file()->associate($file);
        $entity->order()->associate($order);

        return $entity;
    }

    public function save(OrderDoc $entity, array $options = []): bool
    {
        return $entity->save($options);
    }

    /**
     * @return Collection|OrderDoc[]
     */
    public function getByOrder(Order $order): Collection
    {
        return $order->files;
    }
}
