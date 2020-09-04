<?php

declare(strict_types=1);

namespace App\Jobs\Message;

use App\Events\Message\MessageCreatedEvent;
use App\Models\User;
use App\Repositories\MessageRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Queue\InteractsWithQueue;

class CreateMessage implements ShouldQueue
{
    use Queueable;
    use DispatchesJobs;
    use InteractsWithQueue;

    private int $userId;

    private int $orderId;

    private array $messageAttributes;

    public function __construct(int $userId, int $orderId, array $messageAttributes)
    {
        $this->userId = $userId;
        $this->orderId = $orderId;
        $this->messageAttributes = $messageAttributes;
    }

    public function handle(
        UserRepository $userRepository,
        OrderRepository $orderRepository,
        MessageRepository $messageRepository
    ): void {
        /** @var User $user */
        $user = $userRepository->find($this->userId);

        if (is_null($user)) {
            $this->failPostHandle();

            return;
        }

        $order = $orderRepository->findForUser(
            $this->orderId,
            $userRepository->getTypeModel($user)
        );

        if (is_null($order)) {
            $this->failPostHandle();

            return;
        }

        $message = $messageRepository->create($user, $order, $this->messageAttributes);

        if (!$messageRepository->save($message)) {
            $this->failPostHandle();

            return;
        }

        event(
            new MessageCreatedEvent($user->id)
        );
    }

    public function failPostHandle(): void
    {
        event();
    }
}
