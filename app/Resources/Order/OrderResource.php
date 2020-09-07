<?php

declare(strict_types=1);

namespace App\Resources\Order;

use App\Models\Order;
use App\Models\OrderPart;
use App\Resources\DefaultResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /** @var Order */
    public $resource;

    public function toArray($request)
    {
        $orderParts = $this->resource->parts;

        return array_merge(
            parent::toArray($request),
            [
                'subject' => DefaultResource::make($this->resource->subject),
                'parts' => OrderPartResource::collection($orderParts),
                'files' => OrderFileResource::collection(
                    $this->resource->files
                ),
                'readiness' => $this->getOrderReadyPercent($orderParts)
            ]
        );
    }

    private function getOrderReadyPercent(Collection $orderParts): int
    {
        $doneCount = $orderParts
            ->filter(static function (OrderPart $item) {
                return $item->isCompleted();
            })
            ->count();

        return (int) round($doneCount / $orderParts->count() * 100);
    }
}
