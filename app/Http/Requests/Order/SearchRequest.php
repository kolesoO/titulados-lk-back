<?php

declare(strict_types=1);

namespace App\Http\Requests\Order;

use App\Contracts\Models\HasOrderStatus;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class SearchRequest extends Request
{
    public function rules(): array
    {
        return [];
    }
}
