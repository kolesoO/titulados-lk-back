<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read float $amount
 * @property-read File $invoiceFile
 */
class OrderPayment extends Model
{
    /** @inheritDoc */
    protected $table = 'order_payments';

    public function invoiceFile(): BelongsTo
    {
        return $this->belongsTo(File::class, 'invoice_file_id');
    }
}
