<?php

use App\Repositories\OrderPartRepository;
use App\Repositories\OrderRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    private array $orderData = [
        'deadline' => '2020-09-02 08:18:29',
        'name' => 'Заказ №',
        'course' => '1',
        'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book',
        'price' => 1000,
        'parts' => [
            ['name' => '1 часть'],
            ['name' => '2 часть'],
            ['name' => '3 часть'],
        ],
    ];

    public function run(
        UserRepository $userRepository,
        OrderRepository $orderRepository,
        OrderPartRepository $orderPartRepository,
        SubjectRepository $subjectRepository
    )
    {
        $mainCounter = 0;
        $subjects = $subjectRepository->newQuery()->limit(3)->get();

        foreach ($userRepository->getActiveStudents() as $student) {
            for ($counter = 0; $counter <= 5; $counter ++) {
                $order = $orderRepository->createModel(
                    $student,
                    array_merge($this->orderData, ['name' => $this->orderData['name'] . $mainCounter])
                );
                $order->subject()->associate(
                    $subjects[rand(0,2)]
                );
                $orderRepository->save($order);

                foreach ($this->orderData['parts'] as $orderPart) {
                    $orderPartRepository->save(
                        $orderPartRepository->create($order, $orderPart)
                    );
                }

                $mainCounter ++;
            }
        }
    }
}
