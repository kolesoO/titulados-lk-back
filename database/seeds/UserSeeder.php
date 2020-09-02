<?php

use App\DTO\User\ModelAttributes;
use App\DTO\User\Settings;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\Tokenizer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private static array $usersData = [
        [
            'email' => 'test@test.ru',
            'phone' => '+7(911)111-11-11',
            'surname' => 'Иванов',
            'name' => 'Иван',
            'last_name' => 'Иванович',
            'city' => 'Санкт-Петербург',
            'password' => '123',
            'type' => User::STUDENT_TYPE,
            'university' => 'БГТУ Военмех',
            'course' => '1',
        ],
        [
            'email' => 'test2@test.ru',
            'phone' => '+7(911)111-11-12',
            'surname' => 'Петров',
            'name' => 'Петр',
            'last_name' => 'Петрович',
            'city' => 'Санкт-Петербург',
            'password' => '123',
            'type' => User::STUDENT_TYPE,
            'university' => 'БГТУ Военмех',
            'course' => '3',
        ],
        [
            'email' => 'tes3@test.ru',
            'phone' => '+7(911)111-11-13',
            'surname' => 'Александров',
            'name' => 'Александр',
            'last_name' => 'Александрович',
            'city' => 'Санкт-Петербург',
            'password' => '123',
            'type' => User::TEACHER_TYPE,
        ]
    ];

    public static function getUsersData(): array
    {
        return self::$usersData;
    }

    /**
     * @throws ReflectionException
     */
    public function run(UserRepository $userRepository, Tokenizer $tokenizer)
    {
        User::reguard();

        foreach (self::$usersData as $userData) {
            if ($userRepository->findByEmail($userData['email'])) {
                continue;
            }

            $user = $userRepository->createModel(
                (new ModelAttributes($userData))
                    ->setSettings(
                        new Settings([])
                    )
                    ->setPassword($userData['password'])
            );
            $userRepository->save($user);
            $userRepository->updateToken($user, $tokenizer->getHash());

            $userType = $userRepository->createTypeModel($userData['type'], $userData);
            $userType->user()->associate($user);

            /** @var Model $userType */
            $userRepository->saveType($userType);
        }
    }
}
