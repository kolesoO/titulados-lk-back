<?php

use App\Repositories\SubjectGroupRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /** @var array[] */
    private $data = [
        [
            'caption' => 'Технические',
            'items' => [
                ['caption' => 'Авиационная и ракетно-космическая техника'],
                ['caption' => 'Автоматизация технологических процессов'],
                ['caption' => 'Автоматика и управление'],
                ['caption' => 'Архитектура и строительство'],
                ['caption' => 'Базы данных'],
                ['caption' => 'Геометрия'],
                ['caption' => 'Гидравлика'],
                ['caption' => 'Детали машин'],
                ['caption' => 'Информатика'],
                ['caption' => 'Информационная безопасность'],
                ['caption' => 'Информационные технологии'],
                ['caption' => 'Материаловедение'],
                ['caption' => 'Машиностроение'],
                ['caption' => 'Металлургия'],
                ['caption' => 'Метрология'],
                ['caption' => 'Механика'],
                ['caption' => 'Начертательная геометрия'],
                ['caption' => 'Приборостроение и оптотехника'],
                ['caption' => 'Программирование'],
                ['caption' => 'Процессы и аппараты'],
                ['caption' => 'Радиофизика'],
                ['caption' => 'Сопротивление материалов'],
                ['caption' => 'Телевидение'],
                ['caption' => 'Теоретическая механика'],
                ['caption' => 'Теория вероятностей'],
                ['caption' => 'Теория машин и механизмов'],
                ['caption' => 'Теплоэнергетика и теплотехника'],
                ['caption' => 'Технологические машины и оборудование'],
                ['caption' => 'Технология продовольственных продуктов и товаров'],
                ['caption' => 'Транспортные средства'],
                ['caption' => 'Физика'],
                ['caption' => 'Чертежи'],
                ['caption' => 'Черчение'],
                ['caption' => 'Электроника, электротехника, радиотехника'],
                ['caption' => 'Энергетическое машиностроение'],
            ],
        ],
        [
            'caption' => 'Экономические',
            'items' => [
                ['caption' => 'Анализ хозяйственной деятельности'],
                ['caption' => 'Антикризисное управление'],
                ['caption' => 'Банковское дело'],
                ['caption' => 'Бизнес-планирование'],
                ['caption' => 'Бухгалтерский учет и аудит'],
                ['caption' => 'Внешнеэкономическая деятельность'],
                ['caption' => 'Гостиничное дело'],
                ['caption' => 'Государственное и муниципальное управление'],
                ['caption' => 'Деньги'],
                ['caption' => 'Инвестиции'],
                ['caption' => 'Инновационный менеджмент'],
                ['caption' => 'Кредит'],
                ['caption' => 'Логистика'],
                ['caption' => 'Маркетинг'],
                ['caption' => 'Менеджмент'],
                ['caption' => 'Менеджмент организации'],
                ['caption' => 'Микро-, макроэкономика'],
                ['caption' => 'Налоги'],
                ['caption' => 'Организационное развитие'],
                ['caption' => 'Производственный маркетинг и менеджмент'],
                ['caption' => 'Рынок ценных бумаг'],
                ['caption' => 'Стандартизация'],
                ['caption' => 'Статистика'],
                ['caption' => 'Стратегический менеджмент'],
                ['caption' => 'Страхование'],
                ['caption' => 'Таможенное дело'],
                ['caption' => 'Теория управления'],
                ['caption' => 'Товароведение'],
                ['caption' => 'Торговое дело'],
                ['caption' => 'Туризм'],
                ['caption' => 'Управление персоналом'],
                ['caption' => 'Финансовый менеджмент'],
                ['caption' => 'Финансы'],
                ['caption' => 'Ценообразование и оценка бизнеса'],
                ['caption' => 'Эконометрика'],
                ['caption' => 'Экономика'],
                ['caption' => 'Экономика предприятия'],
                ['caption' => 'Экономика труда'],
                ['caption' => 'Экономическая теория'],
                ['caption' => 'Экономический анализ'],
            ],
        ],
        [
            'caption' => 'Естественные',
            'items' => [
                ['caption' => 'Астрономия'],
                ['caption' => 'Безопасность жизнедеятельности'],
                ['caption' => 'Биология'],
                ['caption' => 'Ветеринария'],
                ['caption' => 'География'],
                ['caption' => 'Геодезия'],
                ['caption' => 'Геология'],
                ['caption' => 'Естествознание'],
                ['caption' => 'Медицина'],
                ['caption' => 'Нефтегазовое дело'],
                ['caption' => 'Химия'],
                ['caption' => 'Хирургия'],
                ['caption' => 'Экология'],
            ],
        ],
        [
            'caption' => 'Гуманитарные',
            'items' => [
                ['caption' => 'Библиотечно-информационная деятельность'],
                ['caption' => 'Дизайн'],
                ['caption' => 'Документоведение и архивоведение'],
                ['caption' => 'Журналистика'],
                ['caption' => 'Искусство'],
                ['caption' => 'История'],
                ['caption' => 'Конфликтология'],
                ['caption' => 'Криминалистика'],
                ['caption' => 'Культурология'],
                ['caption' => 'Литература'],
                ['caption' => 'Логика'],
                ['caption' => 'Международные отношения'],
                ['caption' => 'Музыка'],
                ['caption' => 'Педагогика'],
                ['caption' => 'Политология'],
                ['caption' => 'Право и юриспруденция'],
                ['caption' => 'Психология'],
                ['caption' => 'Реклама и PR'],
                ['caption' => 'Религия'],
                ['caption' => 'Русский язык'],
                ['caption' => 'Связи с общественностью'],
                ['caption' => 'Социальная работа'],
                ['caption' => 'Социология'],
                ['caption' => 'Страноведение'],
                ['caption' => 'Физическая культура'],
                ['caption' => 'Философия'],
                ['caption' => 'Этика'],
                ['caption' => 'Языки (переводы)'],
                ['caption' => 'Языкознание и филология'],
            ],
        ]
    ];

    public function run(
        SubjectGroupRepository $subjectGroupRepository,
        SubjectRepository $subjectRepository
    ) {
        foreach ($this->data as $groupData) {
            $group = $subjectGroupRepository->createModel(['caption' => $groupData['caption']]);
            $subjectGroupRepository->save($group);

            foreach ($groupData['items'] as $subjectData) {
                $subjectRepository->save(
                    $subjectRepository->createModel($group, ['caption' => $subjectData['caption']])
                );
            }
        }
    }
}