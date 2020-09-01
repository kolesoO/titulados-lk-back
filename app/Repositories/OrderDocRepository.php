<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\File;
use App\Models\OrderDoc;
use App\Models\OrderPart;
use Illuminate\Database\Eloquent\Collection;

class OrderDocRepository extends Base
{
    protected string $modelClass = OrderDoc::class;

    public function create(File $file, OrderPart $orderPart): OrderDoc
    {
        $entity = new OrderDoc();
        $entity->file()->associate($file);
        $entity->orderPart()->associate($orderPart);

        return $entity;
    }

    public function save(OrderDoc $entity, array $options = []): bool
    {
        return $entity->save($options);
    }

    /**
     * @return Collection|OrderDoc[]
     */
    public function getByOrderPart(OrderPart $orderPart): Collection
    {
        return $orderPart->docs;
    }
}
