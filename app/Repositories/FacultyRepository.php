<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\FacultiesDictionary;
use Illuminate\Support\Collection;

class FacultyRepository extends Base
{
    protected string $modelClass = FacultiesDictionary::class;

    public function createModel(array $attributes = []): FacultiesDictionary
    {
        return new FacultiesDictionary($attributes);
    }

    public function save(FacultiesDictionary $entity, array $options = []): bool
    {
        return $entity->save($options);
    }

    public function all(): Collection
    {
        return FacultiesDictionary::all();
    }

    public function findByCaption(string $caption): ?FacultiesDictionary
    {
        /** @var FacultiesDictionary|null $result */
        $result = FacultiesDictionary::query()
            ->where('caption', $caption)
            ->first();

        return $result;
    }

    public function findByIds(array $ids): Collection
    {
        return FacultiesDictionary::query()
            ->whereIn('id', $ids)
            ->get();
    }
}
