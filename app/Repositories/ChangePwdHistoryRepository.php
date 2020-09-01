<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ChangePasswordHistory;

class ChangePwdHistoryRepository extends Base
{
    protected string $modelClass = ChangePasswordHistory::class;

    public function createModel(array $attributes = []): ChangePasswordHistory
    {
        return new ChangePasswordHistory($attributes);
    }

    public function save(ChangePasswordHistory $entity, array $options = []): bool
    {
        return $entity->save($options);
    }
}
