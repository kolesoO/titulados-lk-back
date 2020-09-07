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
 */
class TeacherInfo extends Model implements HasUserType
{
    /** @inheritDoc */
    public $timestamps = false;

    /** @inheritDoc */
    protected $table = 'teachers_info';

    /** @inheritDoc */
    protected $fillable = ['id'];

    /** @inheritDoc */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** @inheritDoc */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'teacher_id');
    }

    /** @inheritDoc */
    public function availableOrdersForeignKey(): ?string
    {
        return 'teacher_id';
    }
}
