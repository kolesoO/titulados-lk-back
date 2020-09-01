<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read int $user_id
 */
class ChangePasswordHistory extends Model
{
    public const UPDATED_AT = null;

    /** @inheritDoc */
    protected $table = 'change_password_history';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
