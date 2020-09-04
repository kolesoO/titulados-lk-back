<?php

declare(strict_types=1);

namespace App\Resources;

use App\Models\SubjectGroup;
use Illuminate\Http\Resources\Json\JsonResource;

class SubjectGroupResource extends JsonResource
{
    /** @var SubjectGroup */
    public $resource;

    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            ['subjects' => DefaultResource::collection($this->resource->subjects)]
        );
    }
}
