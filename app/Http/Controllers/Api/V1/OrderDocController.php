<?php

declare(strict_types=1);

namespace app\Http\Controllers\Api\V1;

use App\Concerns\HasAuthUser;
use App\Models\OrderDoc;
use App\Models\User;
use App\Repositories\OrderDocRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class OrderDocController
{
    use HasAuthUser;

    private OrderRepository $orderRepository;

    private UserRepository $userRepository;

    private OrderDocRepository $orderDocRepository;

    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        OrderDocRepository $orderDocRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->orderDocRepository = $orderDocRepository;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function show(string $orderId, string $fileId): BinaryFileResponse
    {
        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        $this->orderRepository->getByIdForUser(
            (int) $orderId,
            $this->userRepository->getTypeModel($user)
        );

        /** @var OrderDoc $orderFile */
        $orderFile = $this->orderDocRepository->getById((int) $fileId);

        return Response::download(
            $orderFile->file->path,
            basename($orderFile->file->path),
            ['Content-Type' => 'application/octet-stream']
        );
    }
}
