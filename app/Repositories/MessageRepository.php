<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Message;
use App\Models\Order;
use App\Models\User;

class MessageRepository extends Base
{
    protected string $modelClass = Message::class;

    public function create(User $user, Order $order, array $attributes = []): Message
    {
        $entity = new Message($attributes);
        $entity->user()->associate($user);
        $entity->order()->associate($order);

        return $entity;
    }

    public function save(Message $entity, array $options = []): bool
    {
        return $entity->save($options);
    }
}
