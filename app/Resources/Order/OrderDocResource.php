<?php

declare(strict_types=1);

namespace App\Resources\Order;

use App\Models\OrderDoc;
use App\Resources\FileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDocResource extends JsonResource
{
    /** @var OrderDoc */
    public $resource;

    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            [
                'file' => FileResource::make(
                    $this->resource->file
                )
            ]
        );
    }
}
