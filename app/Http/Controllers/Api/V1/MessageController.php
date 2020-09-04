<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Concerns\HasAuthUser;
use App\Http\Requests\Message\StoreRequest;
use App\Jobs\Message\CreateMessage;
use App\Models\User;
use App\Repositories\MessageRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MessageController
{
    use HasAuthUser;

    private UserRepository $userRepository;

    private OrderRepository $orderRepository;

    private MessageRepository $messageRepository;

    public function __construct(
        UserRepository $userRepository,
        OrderRepository $orderRepository,
        MessageRepository $messageRepository
    ) {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->messageRepository = $messageRepository;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function store(string $orderId, StoreRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        $order = $this->orderRepository->getByIdForUser(
            (int) $orderId,
            $this->userRepository->getTypeModel($user)
        );

        dispatch(
            new CreateMessage($user->id, $order->id, $request->all())
        );

        return new JsonResponse(null, Response::HTTP_ACCEPTED);
    }
}
