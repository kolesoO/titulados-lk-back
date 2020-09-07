<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Concerns\HasAuthUser;
use App\Contracts\Models\HasOrderStatus;
use App\DTO\SingleMessage;
use App\Models\OrderPart;
use App\Models\User;
use App\Repositories\OrderPartRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Resources\DefaultResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderPartController
{
    use HasAuthUser;

    private OrderRepository $orderRepository;

    private UserRepository $userRepository;

    private OrderPartRepository $orderPartRepository;

    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        OrderPartRepository $orderPartRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderPartRepository = $orderPartRepository;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function accept(string $orderId, string $orderPartId, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        $order = $this->orderRepository->getByIdForUser(
            (int) $orderId,
            $this->userRepository->getTypeModel($user)
        );

        $orderPart = $this->orderPartRepository->getByIdForOrder(
            (int) $orderPartId,
            $order
        );

        if ($orderPart->status === HasOrderStatus::DONE_STATUS) {
            return new JsonResponse(
                DefaultResource::make(
                    new SingleMessage('Order part already accepted')
                )->resolve(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $prevOrderParts = $this->orderPartRepository->getPreviousForOrder($orderPart, $order);

        if ($prevOrderParts->count() > 0) {
            $prevDoneOrderParts = $prevOrderParts
                ->filter(static function (OrderPart $item) {
                    return $item->status === HasOrderStatus::DONE_STATUS;
                });

            if ($prevDoneOrderParts->count() != $prevOrderParts->count()) {
                return new JsonResponse(
                    DefaultResource::make(
                        new SingleMessage('Previous order parts not accepted')
                    )->resolve(),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
        }

        $orderPart->status = HasOrderStatus::DONE_STATUS;
        $this->orderPartRepository->save($orderPart);

        $nextOrderParts = $this->orderPartRepository->getNextForOrder($orderPart, $order);

        if ($nextOrderParts->count() > 0) {
            /** @var OrderPart $nextOrderPart */
            $nextOrderPart = $nextOrderParts->first();
            $nextOrderPart->status = HasOrderStatus::IN_PROGRESS_STATUS;

            $this->orderPartRepository->save($nextOrderPart);
        } else {
            $order->status = HasOrderStatus::DONE_STATUS;
            $this->orderRepository->save($order);
        }

        return DefaultResource::make($orderPart)
            ->response($request);
    }
}
