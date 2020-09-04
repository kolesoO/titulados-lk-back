<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read User $user
 * @property-read Order $order
 * @property-read string $text
 */
class Message extends Model
{
    public const UPDATED_AT = null;

    /** @inheritDoc */
    protected $table = 'messages';

    /** @inheritDoc */
    protected $fillable = ['message'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
