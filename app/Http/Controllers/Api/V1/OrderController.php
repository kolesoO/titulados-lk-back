<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Concerns\HasAuthUser;
use App\Contracts\Models\HasOrderStatus;
use App\DTO\SingleMessage;
use App\Http\Requests\Order\SearchRequest;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateRequest;
use App\Models\Order;
use App\Models\User;
use App\Repositories\FileRepository;
use App\Repositories\OrderFileRepository;
use App\Repositories\OrderPartRepository;
use App\Repositories\OrderRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\UserRepository;
use App\Resources\DefaultResource;
use App\Resources\Order\OrderResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

class OrderController
{
    use HasAuthUser;

    private OrderRepository $orderRepository;

    private UserRepository $userRepository;

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    public function my(SearchRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        $orders = $this->orderRepository->getForUser(
            $this->userRepository->getTypeModel($user),
            $request->get('filter', [])
        );

        return OrderResource::collection($orders)
            ->response($request);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function showMy(string $orderId, Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        $order = $this->orderRepository->getByIdForUser(
            (int) $orderId,
            $this->userRepository->getTypeModel($user)
        );

        return OrderResource::make($order)
            ->response($request);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function updateMy(string $orderId, UpdateRequest $request): JsonResponse
    {
        //админ, ученик, учитель
        //TODO: переделать реализацию на права

        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        $order = $this->orderRepository->getByIdForUser(
            (int) $orderId,
            $this->userRepository->getTypeModel($user)
        );

        $this->orderRepository->update($order, $request->all());

        if ($this->userRepository->isTeacher($user)) {
            $order->teacher()->associate($user);
        }

        return OrderResource::make($order)
            ->response($request);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function storeMy(
        StoreRequest $request,
        OrderPartRepository $orderPartRepository,
        OrderFileRepository $orderFileRepository,
        FileRepository $fileRepository,
        SubjectRepository $subjectRepository
    ): JsonResponse {
        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        if (!$this->userRepository->isStudent($user)) {
            return new JsonResponse(
                'Вы не можете создавать заказы',
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $order = $this->orderRepository->createModel($user->studentInfo, $request->all());
        $order->subject()->associate(
            $subjectRepository->getById($request->get('subject_id'))
        );
        $this->orderRepository->save($order);

        $orderPartRepository->save(
            $orderPartRepository->create($order, ['name' => '1 часть'])
        );

        /** @var UploadedFile $file */
        foreach ($request->file('attachment', []) as $file) {
            $fileEntity = $fileRepository->createFromUploadedFile($file);

            if ($fileRepository->save($fileEntity)) {
                $orderFileRepository->save(
                    $orderFileRepository->create($fileEntity, $order)
                );
            }
        }

        return OrderResource::make($order)
            ->response($request);
    }

    public function availableMy(SearchRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        $orders = $this->orderRepository->getAvailableForUser(
            $this->userRepository->getTypeModel($user),
            $request->get('filter', [])
        );

        return OrderResource::collection($orders)
            ->response($request);
    }

    /**
     * @throws ModelNotFoundException
     */
    public function accept(
        string $orderId,
        Request $request,
        OrderPartRepository $orderPartRepository
    ): JsonResponse {
        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );
        $userType = $this->userRepository->getTypeModel($user);
        $order = $this->orderRepository->findByIdForUser((int) $orderId, $userType);

        if ($order) {
            return new JsonResponse(
                DefaultResource::make(
                    new SingleMessage('Order already accepted')
                )->resolve(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        /** @var Order $order */
        $order = $this->orderRepository->getById((int) $orderId);
        $order->teacher()->associate($userType);
        $this->orderRepository->save($order);

        $orderPart = $orderPartRepository->getFirstForOrder($order);
        $orderPart->status = HasOrderStatus::IN_PROGRESS_STATUS;
        $orderPartRepository->save($orderPart);

        return OrderResource::make($order)
            ->response($request);
    }
}
