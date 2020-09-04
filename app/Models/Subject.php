<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read string $caption
 */
class Subject extends Model
{
    /** @inheritDoc */
    const UPDATED_AT = null;

    /** @inheritDoc */
    protected $table = 'subjects';

    /** @inheritDoc */
    protected $fillable = ['caption'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(SubjectGroup::class, 'group_id');
    }
}
