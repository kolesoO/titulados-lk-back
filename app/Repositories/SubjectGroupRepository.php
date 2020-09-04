<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\SubjectGroup;
use Illuminate\Support\Collection;

class SubjectGroupRepository extends Base
{
    protected string $modelClass = SubjectGroup::class;

    public function createModel(array $attributes = []): SubjectGroup
    {
        return new SubjectGroup($attributes);
    }

    public function save(SubjectGroup $entity, array $options = []): bool
    {
        return $entity->save($options);
    }

    public function all(): Collection
    {
        return SubjectGroup::all();
    }
}
