<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\File;
use App\Models\Order;
use App\Models\OrderFile;

class OrderFileRepository extends Base
{
    protected string $modelClass = OrderFile::class;

    public function create(File $file, Order $order): OrderFile
    {
        $entity = new OrderFile();
        $entity->file()->associate($file);
        $entity->order()->associate($order);

        return $entity;
    }

    public function save(OrderFile $entity, array $options = []): bool
    {
        return $entity->save($options);
    }
}
