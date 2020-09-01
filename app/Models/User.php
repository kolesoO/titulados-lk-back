<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\User\Settings;
use App\DTO\User\Settings as SettingsDTO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property-read int $id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read string $email
 * @property-read string $phone
 * @property-read string $surname
 * @property-read string $name
 * @property-read string $last_name
 * @property-read string $city
 * @property-read File $picture
 * @property string $password
 * @property string $api_token
 * @property SettingsDTO $settings
 * @property-read int $type
 * @property-read StudentInfo $studentInfo
 * @property-read TeacherInfo $teacherInfo
 * @property-read Collection|ChangePasswordHistory[] $changePasswordHistory
 */
class User extends Authenticatable
{
    public const STUDENT_TYPE = 0;
    public const TEACHER_TYPE = 1;

    /** @inheritDoc */
    protected $fillable = [
        'email', 'phone', 'surname', 'name',
        'last_name', 'city', 'password', 'type', 'settings',
    ];

    /** @inheritDoc */
    protected $hidden = [
        'password', 'api_token',
    ];

    /** @inheritDoc */
    protected $casts = [
        'settings' => Settings::class,
    ];

    /** @inheritDoc */
    protected $attributes = [
        'settings' => '{}',
    ];

    /** @inheritDoc */
    protected $table = 'users';

    public function studentInfo(): HasOne
    {
        return $this->hasOne(StudentInfo::class, 'user_id');
    }

    public function teacherInfo(): HasOne
    {
        return $this->hasOne(TeacherInfo::class, 'user_id');
    }

    public function picture(): BelongsTo
    {
        return $this->belongsTo(File::class, 'picture');
    }

    public function changePasswordHistory(): HasMany
    {
        return $this->hasMany(ChangePasswordHistory::class);
    }
}
