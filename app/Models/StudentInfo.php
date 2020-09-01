<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\Models\HasUserType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read int $user_id
 * @property string $university
 * @property string $course
 */
class StudentInfo extends Model implements HasUserType
{
    /** @inheritDoc */
    public $timestamps = false;

    /** @inheritDoc */
    protected $table = 'students_info';

    /** @inheritDoc */
    protected $fillable = ['university', 'course'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'student_id');
    }
}
