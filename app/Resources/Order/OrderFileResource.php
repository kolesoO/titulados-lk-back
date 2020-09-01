<?php

declare(strict_types=1);

namespace App\Resources\Order;

use App\Models\OrderFile;
use App\Resources\DefaultResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderFileResource extends JsonResource
{
    /** @var OrderFile */
    public $resource;

    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            [
                'file' => DefaultResource::make(
                    $this->resource->file
                )
            ]
        );
    }
}
