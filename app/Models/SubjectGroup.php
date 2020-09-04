<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read string $caption
 * @property-read Collection|Subject[] $subjects
 */
class SubjectGroup extends Model
{
    /** @inheritDoc */
    protected $table = 'subject_groups';

    /** @inheritDoc */
    protected $fillable = ['caption'];

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class, 'group_id');
    }
}
