<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Concerns\HasAuthUser;
use App\DTO\User\ModelAttributes;
use App\Http\Requests\User\ChangePwdRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use App\Repositories\ChangePwdHistoryRepository;
use App\Repositories\FacultyRepository;
use App\Repositories\UserRepository;
use App\Resources\UserResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController
{
    use HasAuthUser;

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function me(Request $request): JsonResponse
    {
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        return UserResource::make($user)
            ->response($request);
    }

    public function updateMe(UpdateRequest $request, FacultyRepository $facultyRepository): JsonResponse
    {
        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        $userAttributes = new ModelAttributes($request->except('password', 'settings'));

        if ($request->get('settings')) {
            $userSettings = $this->userRepository->createUserSettings(
                $request->get('settings'),
                $user
            );
            $userAttributes->setSettings(
                $userSettings
                    ->setFacultyIds(
                        $facultyRepository->findByIds(
                            $userSettings->getFacultyIds()
                        )
                            ->pluck('id')
                            ->toArray()
                    )
            );
        }

        $this->userRepository->update($user, $userAttributes->toArray());

        /** @var Model $userType */
        $userType = $this->userRepository->getTypeModel($user);
        $this->userRepository->updateType($userType, $userAttributes->toArray());

        return UserResource::make($user)
            ->response($request);
    }

    public function changePassword(
        ChangePwdRequest $request,
        ChangePwdHistoryRepository $changePwdHistoryRepository
    ): JsonResponse {
        /** @var User $user */
        $user = $this->userRepository->getById(
            $this->getUser()->id
        );

        $this->userRepository->updatePassword($user, $request->get('password'));

        $pwdHistory = $changePwdHistoryRepository->createModel();
        $pwdHistory->user()
            ->associate($user);

        $changePwdHistoryRepository->save($pwdHistory);

        return UserResource::make($user)
            ->response($request);
    }
}
