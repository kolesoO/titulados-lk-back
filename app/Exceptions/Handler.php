<?php

namespace App\Exceptions;

use \App\DTO\SingleMessage;
use App\Resources\DefaultResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /** @inheritDoc */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return new JsonResponse(
                DefaultResource::make(
                    new SingleMessage($exception->getMessage())
                )->resolve(),
                Response::HTTP_NOT_FOUND
            );
        }

        return parent::render($request, $exception);
    }

    /** @inheritDoc */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return new JsonResponse(
            DefaultResource::make(
                new SingleMessage($exception->getMessage())
            )->resolve(),
            Response::HTTP_UNAUTHORIZED
        );
    }
}
