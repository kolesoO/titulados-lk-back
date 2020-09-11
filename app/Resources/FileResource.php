<?php
declare(strict_types=1);

namespace App\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
{
    /** @var File */
    public $resource;

    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            ['name' => basename($this->resource->path)]
        );
    }
}
