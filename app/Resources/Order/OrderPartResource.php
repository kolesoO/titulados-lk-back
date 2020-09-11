<?php

declare(strict_types=1);

namespace App\Resources\Order;

use App\Models\OrderPart;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderPartResource extends JsonResource
{
    /** @var OrderPart */
    public $resource;

    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            [
                'docs' => OrderPartDocResource::collection($this->resource->docs),
                'status_message' => trans('order_part.status.' . $this->resource->status),
            ]
        );
    }
}
