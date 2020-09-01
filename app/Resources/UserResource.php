<?php

declare(strict_types=1);

namespace App\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /** @var User */
    public $resource;

    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            [
                'student_info' => $this->resource->studentInfo,
                'teacher_info' => $this->resource->teacherInfo,
                'picture' => $this->resource->picture,
                'password_update' => $this->resource->changePasswordHistory()
                    ->orderByDesc('id')
                    ->first()
            ]
        );
    }
}
