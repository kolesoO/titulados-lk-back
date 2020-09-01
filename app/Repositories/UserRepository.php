<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Models\HasUserType;
use app\DTO\User\ModelAttributes;
use App\DTO\User\Settings;
use App\Models\StudentInfo;
use App\Models\TeacherInfo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use ReflectionClass;
use ReflectionException;

class UserRepository extends Base
{
    protected string $modelClass = User::class;

    /** @var string[] */
    private array $typeMap = [
        User::STUDENT_TYPE => StudentInfo::class,
        User::TEACHER_TYPE => TeacherInfo::class,
    ];

    public function createModel(ModelAttributes $attributes): User
    {
        $attributes = array_merge(
            $attributes->toArray(),
            [
                'password' => Hash::make($attributes->getPassword()),
                'settings' => $this->createUserSettings(
                    $attributes->getSettings()->toArray()
                ),
            ]
        );

        return new User($attributes);
    }

    /**
     * @throws ReflectionException
     */
    public function createTypeModel(int $type, array $attributes = []): HasUserType
    {
        $reflection = new ReflectionClass($this->typeMap[$type]);

        /** @var HasUserType $result */
        $result = $reflection->newInstanceArgs(
            compact('attributes')
        );

        return $result;
    }

    public function getTypeModel(User $entity): HasUserType
    {
        if ($entity->type === User::STUDENT_TYPE) {
            return $entity->studentInfo;
        }

        return $entity->teacherInfo;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByEmail(string $email): User
    {
        /** @var User $result */
        $result = $this->newQuery()
            ->where(['email' => $email])
            ->firstOrFail();

        return $result;
    }

    public function findByEmail(string $email): ?User
    {
        /** @var User|null $result */
        $result = $this->newQuery()
            ->where(['email' => $email])
            ->first();

        return $result;
    }

    public function updateToken(User $entity, string $hash): bool
    {
        $entity->api_token = $hash;

        return $this->save($entity);
    }

    public function updatePassword(User $entity, string $password): bool
    {
        $entity->password = Hash::make($password);

        return $this->save($entity);
    }

    public function save(User $entity, array $options = []): bool
    {
        return $entity->save($options);
    }

    public function update(User $entity, array $attributes = [], array $options = []): bool
    {
        return $entity->update($attributes, $options);
    }

    public function saveType(Model $entity, array $options = []): bool
    {
        return $entity->save($options);
    }

    public function updateType(Model $entity, array $attributes = [], array $options = []): bool
    {
        return $entity->update($attributes, $options);
    }

    public function createUserSettings(array $sourceSettings, ?User $entity = null): Settings
    {
        if (!is_null($entity)) {
            /** @var Settings $originalSettings */
            $originalSettings = $entity->getOriginal('settings');

            $sourceSettings = array_merge($originalSettings->getArray(), $sourceSettings);
        }

        return new Settings($sourceSettings);
    }

    public function isStudent(User $entity): bool
    {
        return $entity->type === User::STUDENT_TYPE;
    }

    public function isTeacher(User $entity): bool
    {
        return $entity->type === User::TEACHER_TYPE;
    }
}
