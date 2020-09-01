<?php

declare(strict_types=1);

namespace App\Contracts\Models;

interface HasOrderStatus
{
    public const NEW_STATUS = 0;
    public const IN_PROGRESS_STATUS = 1;
    public const DONE_STATUS = 2;
}
