<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read string $caption
 */
class FacultiesDictionary extends Model
{
    /** @inheritDoc */
    public $timestamps = false;

    /** @inheritDoc */
    protected $table = 'faculties_dictionary';

    /** @inheritDoc */
    protected $fillable = ['caption'];
}
