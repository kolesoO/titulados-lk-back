<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Concerns\HasAuthUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use App\Resources\DefaultResource;
use App\Services\Tokenizer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
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
    public function login(LoginRequest $request, Tokenizer $tokenizer): JsonResponse
    {
        $user = $this->userRepository->getByEmail(
            $request->get('email')
        );

        if (!Hash::check($request->get('password'), $user->password)) {
            return new JsonResponse('Invalid password', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$this->userRepository->updateToken($user, $tokenizer->getHash())) {
            return new JsonResponse('Fail to update access token', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return DefaultResource::make($user)
            ->additional(['api_token' => $tokenizer->getToken()])
            ->response($request);
    }
}
