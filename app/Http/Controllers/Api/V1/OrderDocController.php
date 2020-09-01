<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Concerns\HasAuthUser;
use App\Http\Requests\OrderDoc\StoreRequest;
use App\Models\User;
use App\Repositories\FileRepository;
use App\Repositories\OrderDocRepository;
use App\Repositories\OrderPartRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Resources\Order\OrderDocResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderDocController
{
    use HasAuthUser;

    private OrderRepository $orderRepository;

    private OrderPartRepository $orderPartRepository;

    private OrderDocRepository $orderDocRepository;

    private UserRepository $userRepository;

    public function __construct(
        OrderPartRepository $orderPartRepository,
        OrderDocRepository $orderDocRepository,
        OrderRepository $orderRepository,
        UserRepository $userRepository
    ) {
        $this->orderPartRepository = $orderPartRepository;
        $this->orderDocRepository = $orderDocRepository;
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
            $this->orderDocRepository->getByOrderPart($orderPart)
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

        $orderDoc = $this->orderDocRepository->create($fileEntity, $orderPart);

        if (!$fileRepository->save($fileEntity)) {
            throw (new ModelNotFoundException)->setModel(
                get_class($orderDoc)
            );
        }

        $this->orderDocRepository->save($orderDoc);

        return OrderDocResource::make($orderDoc)
            ->response($request);
    }
}
