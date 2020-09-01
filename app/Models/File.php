<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read int $size
 * @property-read string $content_type
 * @property string $path
 */
class File extends Model
{
    /** @inheritDoc */
    protected $table = 'files';
}
