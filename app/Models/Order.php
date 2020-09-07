<?php

namespace App\Models;

use App\Contracts\Models\HasOrderStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon $deadline
 * @property-read string $name
 * @property int $status
 * @property-read Subject $subject
 * @property-read string $course
 * @property-read string $description
 * @property-read float $price
 * @property-read StudentInfo $student
 * @property-read TeacherInfo $teacher
 * @property-read Collection|OrderPart[] $parts
 * @property-read Collection|OrderFile[] $files
 */
class Order extends Model implements HasOrderStatus
{
    /** @inheritDoc */
    protected $table = 'orders';

    /** @inheritDoc */
    protected $fillable = [
        'deadline', 'name', 'type', 'course',
        'description', 'price',
    ];

    /** @inheritDoc */
    protected $filterable = [
        'name', 'status',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function parts(): HasMany
    {
        return $this->hasMany(OrderPart::class, 'order_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(OrderFile::class, 'order_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(StudentInfo::class, 'student_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(TeacherInfo::class, 'teacher_id');
    }
}
