<?php

namespace App\Models;

use App\Contracts\Models\HasOrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read string $name
 * @property int $status
 * @property-read Order $order
 * @property-read Collection|OrderPartDoc[] $docs
 */
class OrderPart extends Model implements HasOrderStatus
{
    /** @inheritDoc */
    protected $table = 'order_parts';

    /** @inheritDoc */
    protected $fillable = ['name'];

    public function docs(): HasMany
    {
        return $this->hasMany(OrderPartDoc::class, 'order_part_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function isCompleted(): bool
    {
        return $this->status === self::DONE_STATUS;
    }
}
