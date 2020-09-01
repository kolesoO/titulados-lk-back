<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasAuthUser
{
    protected function getUser(): User
    {
        /** @var User|null $user */
        $user = Auth::guard('api')->user();

        return $user;
    }
}
