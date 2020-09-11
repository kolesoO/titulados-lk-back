<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\File;
use App\Models\OrderPartDoc;
use App\Models\OrderPart;
use Illuminate\Database\Eloquent\Collection;

class OrderPartDocRepository extends Base
{
    protected string $modelClass = OrderPartDoc::class;

    public function create(File $file, OrderPart $orderPart): OrderPartDoc
    {
        $entity = new OrderPartDoc();
        $entity->file()->associate($file);
        $entity->orderPart()->associate($orderPart);

        return $entity;
    }

    public function save(OrderPartDoc $entity, array $options = []): bool
    {
        return $entity->save($options);
    }

    /**
     * @return Collection|OrderPartDoc[]
     */
    public function getByOrderPart(OrderPart $orderPart): Collection
    {
        return $orderPart->docs;
    }
}
