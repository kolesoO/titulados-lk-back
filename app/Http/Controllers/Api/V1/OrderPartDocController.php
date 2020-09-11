<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Concerns\HasAuthUser;
use App\Http\Requests\OrderPartDoc\StoreRequest;
use App\Models\User;
use App\Repositories\FileRepository;
use App\Repositories\OrderPartDocRepository;
use App\Repositories\OrderPartRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Resources\Order\OrderDocResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderPartDocController
{
    use HasAuthUser;

    private OrderRepository $orderRepository;

    private OrderPartRepository $orderPartRepository;

    private OrderPartDocRepository $orderPartDocRepository;

    private UserRepository $userRepository;

    public function __construct(
        OrderPartRepository $orderPartRepository,
        OrderPartDocRepository $orderPartDocRepository,
        OrderRepository $orderRepository,
        UserRepository $userRepository
    ) {
        $this->orderPartRepository = $orderPartRepository;
        $this->orderPartDocRepository = $orderPartDocRepository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function my(string $orderId, string $orderPartId, Request $request): JsonResponse
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

        return OrderDocResource::collection(
            $this->orderPartDocRepository->getByOrderPart($orderPart)
        )
            ->response($request);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function storeMy(
        string $orderId,
        string $orderPartId,
        StoreRequest $request,
        FileRepository $fileRepository
    ): JsonResponse {
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

        $fileEntity = $fileRepository->createFromUploadedFile(
            $request->file('attachment')
        );

        $orderDoc = $this->orderPartDocRepository->create($fileEntity, $orderPart);

        if (!$fileRepository->save($fileEntity)) {
            throw (new ModelNotFoundException)->setModel(
                get_class($orderDoc)
            );
        }

        $this->orderPartDocRepository->save($orderDoc);

        return OrderDocResource::make($orderDoc)
            ->response($request);
    }
}
