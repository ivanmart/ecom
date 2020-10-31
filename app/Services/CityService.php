<?php

namespace App\Services;

use App\Models\City;

use Lenius\Basket\Identifier\Cookie;

/**
 * City Service
 * It uses GeoIP database to determine user's city
 */
class CityService
{
    /**
     * Variable contains cities distance from Moscow
     * @var [type]
     */
    public $mkad_km = array(
        "Апрелевка" => 28, "Балашиха" => 6, "Бронницы" => 43, "Верея" => 97, "Видное" => 5, "Волоколамск" => 99,
        "Воскресенск" => 82, "Высоковск" => 80, "Голицыно" => 29, "Дедовск" => 20, "Дзержинский" => 0, "Дмитров" => 57,
        "Долгопрудный" => 0, "Домодедово" => 18, "Дубна" => 107, "Егорьевск" => 94, "Железнодорожный" => 10, "Жуковский" => 24,
        "Зарайск" => 142, "Звенигород" => 43, "Ивантеевка" => 15, "Истра" => 38, "Кашира" => 95, "Климовск" => 26, "Клин" => 65,
        "Коломна" => 94, "Королев" => 5, "Котельники" => 0, "Красноармейск" => 40, "Красногорск" => 3, "Краснозаводск" => 80,
        "Краснознаменск" => 25, "Кубинка" => 48, "Куровское" => 80, "Ликино-Дулево" => 94, "Лобня" => 15, "Лосино-Петровский" => 30,
        "Луховицы" => 116, "Лыткарино" => 14, "Люберцы" => 2, "Можайск" => 91, "Московский" => 7, "Мытищи" => 0,
        "Наро-Фоминск" => 53, "Ногинск" => 35, "Одинцово" => 6, "Ожерелье" => 109, "Озёры" => 129, "Орехово-Зуево" => 78,
        "Павловский Посад" => 62, "Пересвет" => 77, "Подольск" => 16, "Протвино" => 99, "Пушкино" => 18, "Пущино" => 94,
        "Раменское" => 34, "Реутов" => 0, "Рошаль" => 147, "Руза" => 90, "Сергиев Посад" => 52, "Серпухов" => 83,
        "Солнечногорск" => 43, "Старая Купавна" => 20, "Ступино" => 83, "Талдом" => 103, "Троицк" => 17, "Фрязино" => 23,
        "Химки" => 0, "Хотьково" => 52, "Черноголовка" => 42, "Чехов" => 49, "Шатура" => 124, "Щёлково" => 17, "Щербинка" => 7,
        "Электрогорск" => 64, "Электросталь" => 38, "Электроугли" => 23, "Юбилейный" => 8, "Яхрома" => 46
    );

    /**
     * Variable contains cities distance from Saint-Petersburg
     * @var [type]
     */
    public $kad_km = array(
        "Агалатово" => 34, "Александровская" => 19, "Аннино" => 10, "Аннолово" => 27, "Б.Ижора" => 44, "Б.О. Окунёвая" => 100,
        "Белоостров" => 36, "Бокситогорск" => 260, "Бугры" => 2, "Будогощь" => 181, "Ваганово" => 39, "Васкелово" => 39, "Верево" => 24,
        "Виллози" => 30, "Вирки" => 14, "Вознесенье" => 343, "Войсковицы" => 40, "Войскорово" => 19, "Волосово" => 76,
        "Волосово (Волховский)" => 150, "Волхов" => 130, "Всеволжск" => 22, "Выборг" => 132, "Выра" => 61, "Вырица" => 69, "Высоцк" => 161,
        "Ганино" => 87, "Гарболово" => 49, "Гатчина" => 38, "Горбунки" => 16, "Горелово" => 11, "Горская" => 17, "Горьковское" => 77,
        "Гостилицы" => 49, "Грибное" => 41, "Громово" => 98, "Грузино" => 50, "Девяткино" => 2, "Дибуны" => 12, "Дранишники" => 10,
        "Дружная Горка" => 77, "Жилгородок" => 16, "Заводской" => 100, "Заводской (Всеволожский)" => 50, "Захонье (Волосовский)" => 42,
        "Захонье (Кингисеппский)" => 135, "Захонье (Лужский)" => 160, "Зеленогорск" => 55, "Ивангород" => 146, "им. Морозова" => 33,
        "им. Свердлова" => 13, "Кавголово" => 35, "Каменногорск" => 171, "Канисты" => 17, "Каннельярви" => 80, "Касимово" => 20,
        "Келози" => 28, "Кикерино" => 60, "Кингисепп" => 125, "Кипень" => 27, "Кирилловское" => 96, "Кириши" => 170, "Кировск" => 48,
        "Кобринское" => 50, "Колпино" => 35, "Колтуши" => 10, "Комарово" => 40, "Коммунар" => 30, "Кондакопшино" => 20,
        "Коркинские озёра" => 15, "Коробицыно" => 80, "Красная Звезда" => 9, "Красное Село" => 12, "Красный Бор" => 24, "Кривко" => 67,
        "Кронштадт" => 33, "Кузьмолово" => 13, "Кузьмоловский" => 11, "Куйвози" => 41, "Лаврики" => 11, "Лаголово" => 20, "Лебяжье" => 49,
        "Лемболово" => 59, "Ленинское" => 37, "Лесколово" => 63, "Лесное (племзавод)" => 19, "Лесогорский" => 191, "Лисий Нос" => 21,
        "Лодейное Поле" => 230, "Ломоносов" => 30, "Лосево" => 80, "Лукаши" => 38, "Лупполово" => 14, "Любань" => 68, "Мартышкино" => 25,
        "Мга" => 50, "Медвежий Стан" => 4, "Медный завод" => 19, "Мичуринское" => 100, "Можайский" => 17, "Молодёжное" => 100, "Мурино" => 2,
        "Мшинская (дер)" => 100, "Невская Дубровка" => 27, "Ненимяки" => 38, "Нижние Осельки" => 32, "Низино" => 25,
        "Никольское (Бокситогорский)" => 345, "Никольское (Гатчинский)" => 52, "Никольское (Кировский)" => 67, "Никольское (Ломоносовский)" => 70,
        "Никольское (Тосненский)" => 20, "Новая Ладога" => 120, "Новое Девяткино" => 5, "Новое Токсово" => 26, "Новоселье" => 13,
        "Новый Петергоф" => 19, "Ольгино" => 7, "Оржицы" => 34, "Осиновая Роща" => 6, "Отрадное (запад)" => 195, "Отрадное (север)" => 140,
        "Отрадное (юг)" => 17, "п. Дюны" => 38, "Павловск" => 30, "Парголово" => 4, "Пеники" => 37, "Первомайское" => 50, "Пески" => 9,
        "Песочное" => 59, "Петергоф" => 35, "Петровское" => 80, "Пикалево" => 251, "Приморск" => 140, "Приозерск" => 160, "Приютино" => 35,
        "Пушкин" => 37, "Репино" => 50, "Рощино" => 60, "Рощино" => 76, "Светогорск" => 210, "Семиозерье" => 60, "Сертолово" => 24,
        "Сестрорецк" => 37, "Сланцы" => 205, "Сосновый Бор" => 90, "СПб" => 0, "Старая Ладога" => 120, "Сярьги" => 15, "Тихвин" => 230,
        "Токсово" => 23, "Тосно" => 60, "Цвелодубово" => 80, "Чудово" => 120, "Шлиссельбург" => 55
    );

    /**
     * Get current city id
     * @return integer
     */
    public static function getCurrent()
    {
        // get cookie
        $city_id = \Cookie::get('city');

        // get city id
        if ($city_id) {
            $city = City::where('id', $city_id)->get();
        } else {
            $location = geoip($_SERVER['REMOTE_ADDR'])->toArray();
            $city = City::where('cities', strtoupper($location['city']))->get();
        }

        // get city from local DB
        if (!$city || !isset($city[0])) {
            $city = City::where('cities', 'MOSCOW')->get();
        }
        $city = $city[0];

        // set cookie
        if (!$city_id) {
            \Cookie::queue(
              \Cookie::make('city', $city->id, Config::get('geoip.default_city_id'))
            );
        }

        return $city;
    }

    /**
     * Calculate delivery cost
     * @param  integer $products_cost
     * @param  integer $mkad
     * @return integer
     */
    public static function getDeliveryCost($products_cost, $mkad = 0)
    {
        // default cons for kilometer
        // TODO: !!! move values to config
        $mkad_km_cost = $kad_km_cost = 30;

        // minimal order cost for free delivery
        // TODO: !!! move values to config
        $free_delivery = 3000;

        // get current city id
        $city = self::getCurrent();
        $delivery_cost = 0;

        // calculate delivery cost
        // TODO: !!! move values to config
        if ($city) {
            if ($products_cost > 17000) {
                $delivery_cost = 0;
            } elseif ($city->name == "Москва") {
                $delivery_cost = (($products_cost >= $free_delivery) ? 0 : 300) + $mkad * $mkad_km_cost;
            } elseif (preg_match("/Санкт-/ui", $city->name)) {
                $delivery_cost = (($products_cost >= $free_delivery) ? 0 : 300) + $mkad * $kad_km_cost;
            } else {
                $delivery_cost = $city->delivery_cost;
            }
        }

        return $delivery_cost;
    }
}
