<?php

declare(strict_types=1);

namespace app\Http\Controllers\Api\V1;

use App\DTO\User\ModelAttributes;
use App\DTO\User\Settings;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\UserRepository;
use App\Resources\DefaultResource;
use App\Services\Tokenizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use ReflectionException;

class RegisterController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ReflectionException
     */
    public function register(RegisterRequest $request, Tokenizer $tokenizer): JsonResponse
    {
        $user = $this->userRepository->findByEmail(
            $request->get('email')
        );

        if (!is_null($user)) {
            return new JsonResponse('Клиент с таким email уже зарегистрирован', Response::HTTP_CONFLICT);
        }

        $user = $this->userRepository->createModel(
            (new ModelAttributes($request->except('settings', 'password')))
                ->setSettings(
                    new Settings($request->get('settings', []))
                )
                ->setPassword($request->get('password'))
        );

        $this->userRepository->save($user);
        $this->userRepository->updateToken($user, $tokenizer->getHash());

        $userType = $this->userRepository->createTypeModel(
            (int) $request->get('type', -1),
            $request->all()
        );

        $userType->user()->associate($user);

        /** @var $userType Model */
        $this->userRepository->saveType($userType);

        return DefaultResource::make($user)
            ->additional(['api_token' => $tokenizer->getToken()])
            ->response($request);
    }
}
