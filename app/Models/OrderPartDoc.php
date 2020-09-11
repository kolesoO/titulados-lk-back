<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read OrderPart $orderPart
 * @property-read File $file
 * @property-read User $user
 * @property-read string $comment
 */
class OrderPartDoc extends Model
{
    /** @inheritDoc */
    protected $table = 'order_part_docs';

    /** @inheritDoc */
    protected $fillable = ['comment'];

    public function orderPart(): BelongsTo
    {
        return $this->belongsTo(OrderPart::class, 'order_part_id');
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
