<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Subject;
use App\Models\SubjectGroup;
use Illuminate\Support\Collection;

class SubjectRepository extends Base
{
    protected string $modelClass = Subject::class;

    public function createModel(SubjectGroup $group, array $attributes = []): Subject
    {
        $entity = new Subject($attributes);
        $entity->group()->associate($group);

        return $entity;
    }

    public function save(Subject $entity, array $options = []): bool
    {
        return $entity->save($options);
    }

    /**
     * @return Collection|Subject[]
     */
    public function getByGroup(SubjectGroup $group): Collection
    {
        return $group->subjects;
    }

    public function findByIds(array $ids): Collection
    {
        return $this->newQuery()
            ->whereIn('id', $ids)
            ->get();
    }
}
