<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = [
            'anna' => User::query()->updateOrCreate(
                ['email' => 'anna@example.com'],
                [
                    'name' => 'Анна Смирнова',
                    'password' => Hash::make('password'),
                    'phone' => '+7 (901) 000-10-10',
                    'default_address' => 'Самара, ул. Ленина, 10',
                ]
            ),
            'ivan' => User::query()->updateOrCreate(
                ['email' => 'ivan@example.com'],
                [
                    'name' => 'Иван Петров',
                    'password' => Hash::make('password'),
                    'phone' => '+7 (902) 000-20-20',
                    'default_address' => 'Самара, ул. Молодежная, 18',
                ]
            ),
            'maria' => User::query()->updateOrCreate(
                ['email' => 'maria@example.com'],
                [
                    'name' => 'Мария Волкова',
                    'password' => Hash::make('password'),
                    'phone' => '+7 (903) 000-30-30',
                    'default_address' => 'Самара, ул. Полевая, 7',
                ]
            ),
        ];

        $catalog = [
            [
                'restaurant' => [
                    'name' => 'Пицца на районе',
                    'slug' => 'pizza-district',
                    'description' => 'Пицца из печи и паста с быстрой доставкой по району.',
                    'cuisine' => 'Итальянская кухня',
                    'address' => 'Самара, ул. Молодежная, 14',
                    'delivery_time' => 35,
                    'delivery_fee' => 149,
                    'min_order_amount' => 700,
                    'rating' => 4.8,
                    'image' => '/images/restaurants/pizza-district.svg',
                    'is_active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Пицца',
                        'slug' => 'pizza',
                        'sort_order' => 1,
                        'dishes' => [
                            ['name' => 'Маргарита', 'description' => 'Томатный соус, моцарелла, базилик.', 'price' => 549, 'weight_grams' => 480, 'image' => '/images/dishes/pizza.svg'],
                            ['name' => 'Пепперони', 'description' => 'Острая колбаса пепперони, сыр, фирменный соус.', 'price' => 689, 'weight_grams' => 520, 'image' => '/images/dishes/pizza.svg'],
                            ['name' => 'Четыре сыра', 'description' => 'Моцарелла, дорблю, пармезан и сливочный соус.', 'price' => 739, 'weight_grams' => 500, 'image' => '/images/dishes/pizza.svg'],
                        ],
                    ],
                    [
                        'name' => 'Паста',
                        'slug' => 'pasta',
                        'sort_order' => 2,
                        'dishes' => [
                            ['name' => 'Карбонара', 'description' => 'Сливочный соус, бекон, пармезан.', 'price' => 469, 'weight_grams' => 340, 'image' => '/images/dishes/pasta.svg'],
                            ['name' => 'Болоньезе', 'description' => 'Томаты, говяжий фарш, базилик, пармезан.', 'price' => 499, 'weight_grams' => 360, 'image' => '/images/dishes/pasta.svg'],
                        ],
                    ],
                ],
                'reviews' => [
                    ['user' => 'anna', 'rating' => 5, 'comment' => 'Пицца приехала горячей и очень вкусной.'],
                    ['user' => 'ivan', 'rating' => 4, 'comment' => 'Быстрая доставка и хорошее качество блюд.'],
                ],
            ],
            [
                'restaurant' => [
                    'name' => 'Бургерная Двор',
                    'slug' => 'burger-yard',
                    'description' => 'Сочные бургеры, картошка и закуски для обеда и ужина.',
                    'cuisine' => 'Американская кухня',
                    'address' => 'Самара, пр. Победы, 77',
                    'delivery_time' => 28,
                    'delivery_fee' => 99,
                    'min_order_amount' => 500,
                    'rating' => 4.7,
                    'image' => '/images/restaurants/burger-yard.svg',
                    'is_active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Бургеры',
                        'slug' => 'burgers',
                        'sort_order' => 1,
                        'dishes' => [
                            ['name' => 'Чизбургер XXL', 'description' => 'Двойная говяжья котлета, чеддер, соус барбекю.', 'price' => 590, 'weight_grams' => 390, 'image' => '/images/dishes/burger.svg'],
                            ['name' => 'Куриный бургер', 'description' => 'Хрустящее куриное филе, салат, чесночный соус.', 'price' => 430, 'weight_grams' => 310, 'image' => '/images/dishes/burger.svg'],
                            ['name' => 'Бургер с грибами', 'description' => 'Говядина, жареные шампиньоны, сыр и фирменный соус.', 'price' => 540, 'weight_grams' => 360, 'image' => '/images/dishes/burger.svg'],
                        ],
                    ],
                    [
                        'name' => 'Закуски',
                        'slug' => 'snacks',
                        'sort_order' => 2,
                        'dishes' => [
                            ['name' => 'Картофель фри', 'description' => 'Большая порция с кетчупом.', 'price' => 210, 'weight_grams' => 150, 'image' => '/images/dishes/snack.svg'],
                            ['name' => 'Луковые кольца', 'description' => 'Подаются с сырным соусом.', 'price' => 260, 'weight_grams' => 170, 'image' => '/images/dishes/snack.svg'],
                            ['name' => 'Наггетсы', 'description' => 'Хрустящие куриные кусочки с медово-горчичным соусом.', 'price' => 320, 'weight_grams' => 180, 'image' => '/images/dishes/snack.svg'],
                        ],
                    ],
                ],
                'reviews' => [
                    ['user' => 'ivan', 'rating' => 5, 'comment' => 'Большие порции и очень быстрая доставка.'],
                    ['user' => 'maria', 'rating' => 4, 'comment' => 'Всё приехало тёплым, хорошее соотношение цены и качества.'],
                ],
            ],
            [
                'restaurant' => [
                    'name' => 'Суши Волна',
                    'slug' => 'sushi-wave',
                    'description' => 'Роллы и боулы для вечерней доставки.',
                    'cuisine' => 'Японская кухня',
                    'address' => 'Самара, ул. Гагарина, 9',
                    'delivery_time' => 42,
                    'delivery_fee' => 0,
                    'min_order_amount' => 900,
                    'rating' => 4.9,
                    'image' => '/images/restaurants/sushi-wave.svg',
                    'is_active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Роллы',
                        'slug' => 'rolls',
                        'sort_order' => 1,
                        'dishes' => [
                            ['name' => 'Филадельфия', 'description' => 'Лосось, сливочный сыр, огурец.', 'price' => 720, 'weight_grams' => 260, 'image' => '/images/dishes/sushi.svg'],
                            ['name' => 'Калифорния', 'description' => 'Крабовый микс, авокадо, тобико.', 'price' => 640, 'weight_grams' => 240, 'image' => '/images/dishes/sushi.svg'],
                            ['name' => 'Запеченный с угрем', 'description' => 'Рис, угорь, сливочный соус и кунжут.', 'price' => 690, 'weight_grams' => 250, 'image' => '/images/dishes/sushi.svg'],
                        ],
                    ],
                    [
                        'name' => 'Боулы',
                        'slug' => 'bowls',
                        'sort_order' => 2,
                        'dishes' => [
                            ['name' => 'Поке с лососем', 'description' => 'Рис, лосось, эдамаме, манго, соус унаги.', 'price' => 580, 'weight_grams' => 330, 'image' => '/images/dishes/bowl.svg'],
                            ['name' => 'Поке с тунцом', 'description' => 'Рис, тунец, огурец, вакаме и соус понзу.', 'price' => 620, 'weight_grams' => 340, 'image' => '/images/dishes/bowl.svg'],
                        ],
                    ],
                ],
                'reviews' => [
                    ['user' => 'anna', 'rating' => 5, 'comment' => 'Очень свежие роллы и аккуратная упаковка.'],
                    ['user' => 'maria', 'rating' => 5, 'comment' => 'Отличное качество и бесплатная доставка.'],
                ],
            ],
            [
                'restaurant' => [
                    'name' => 'Магнит',
                    'slug' => 'magnit',
                    'description' => 'Супермаркет рядом с домом: свежие продукты, молочка и товары на каждый день.',
                    'cuisine' => 'Продуктовый магазин',
                    'address' => 'Самара, ул. Ново-Садовая, 201',
                    'delivery_time' => 45,
                    'delivery_fee' => 79,
                    'min_order_amount' => 800,
                    'rating' => 4.6,
                    'image' => '/images/restaurants/magnit.svg',
                    'is_active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Овощи и фрукты',
                        'slug' => 'produce',
                        'sort_order' => 1,
                        'dishes' => [
                            ['name' => 'Бананы, 1 кг', 'description' => 'Спелые бананы, фасовка по весу.', 'price' => 169, 'weight_grams' => 1000, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Огурцы тепличные, 500 г', 'description' => 'Хрустящие огурцы для салатов.', 'price' => 119, 'weight_grams' => 500, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Яблоки сезонные, 1 кг', 'description' => 'Сладко-кислые яблоки местной поставки.', 'price' => 159, 'weight_grams' => 1000, 'image' => '/images/dishes/default.svg'],
                        ],
                    ],
                    [
                        'name' => 'Молочные продукты',
                        'slug' => 'dairy',
                        'sort_order' => 2,
                        'dishes' => [
                            ['name' => 'Молоко 3.2%, 900 мл', 'description' => 'Пастеризованное молоко в бутылке.', 'price' => 109, 'weight_grams' => 900, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Кефир 2.5%, 930 мл', 'description' => 'Классический кефир для завтрака.', 'price' => 99, 'weight_grams' => 930, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Творог 5%, 300 г', 'description' => 'Нежный творог без добавок.', 'price' => 149, 'weight_grams' => 300, 'image' => '/images/dishes/default.svg'],
                        ],
                    ],
                    [
                        'name' => 'Бакалея',
                        'slug' => 'pantry',
                        'sort_order' => 3,
                        'dishes' => [
                            ['name' => 'Рис длиннозерный, 900 г', 'description' => 'Подходит для гарниров и плова.', 'price' => 129, 'weight_grams' => 900, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Макароны спагетти, 450 г', 'description' => 'Паста из твердых сортов пшеницы.', 'price' => 95, 'weight_grams' => 450, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Масло оливковое, 500 мл', 'description' => 'Extra virgin, для салатов и готовки.', 'price' => 499, 'weight_grams' => 500, 'image' => '/images/dishes/default.svg'],
                        ],
                    ],
                ],
                'reviews' => [
                    ['user' => 'ivan', 'rating' => 5, 'comment' => 'Удобно, что можно заказать базовые продукты одним кликом.'],
                    ['user' => 'maria', 'rating' => 4, 'comment' => 'Овощи свежие, привезли вовремя.'],
                ],
            ],
            [
                'restaurant' => [
                    'name' => 'Пятёрочка',
                    'slug' => 'pyaterochka',
                    'description' => 'Готовая еда, напитки и товары на каждый день с быстрой доставкой.',
                    'cuisine' => 'Супермаркет',
                    'address' => 'Самара, ул. Победы, 32',
                    'delivery_time' => 40,
                    'delivery_fee' => 69,
                    'min_order_amount' => 700,
                    'rating' => 4.5,
                    'image' => '/images/restaurants/pyaterochka.svg',
                    'is_active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Готовая еда',
                        'slug' => 'ready-meals',
                        'sort_order' => 1,
                        'dishes' => [
                            ['name' => 'Салат Цезарь, 250 г', 'description' => 'Курица, листья салата, сухарики и соус.', 'price' => 229, 'weight_grams' => 250, 'image' => '/images/dishes/bowl.svg'],
                            ['name' => 'Сэндвич с ветчиной и сыром', 'description' => 'Сэндвич на зерновом хлебе, 180 г.', 'price' => 189, 'weight_grams' => 180, 'image' => '/images/dishes/snack.svg'],
                            ['name' => 'Блинчики с мясом, 300 г', 'description' => 'Охлажденная готовая еда, 2 порции.', 'price' => 249, 'weight_grams' => 300, 'image' => '/images/dishes/snack.svg'],
                        ],
                    ],
                    [
                        'name' => 'Напитки',
                        'slug' => 'drinks',
                        'sort_order' => 2,
                        'dishes' => [
                            ['name' => 'Минеральная вода, 1.5 л', 'description' => 'Негазированная питьевая вода.', 'price' => 69, 'weight_grams' => 1500, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Морс клюквенный, 1 л', 'description' => 'Натуральный ягодный напиток.', 'price' => 149, 'weight_grams' => 1000, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Кола, 1 л', 'description' => 'Газированный напиток.', 'price' => 139, 'weight_grams' => 1000, 'image' => '/images/dishes/default.svg'],
                        ],
                    ],
                    [
                        'name' => 'Заморозка',
                        'slug' => 'frozen',
                        'sort_order' => 3,
                        'dishes' => [
                            ['name' => 'Пельмени домашние, 800 г', 'description' => 'Полуфабрикат из говядины и свинины.', 'price' => 369, 'weight_grams' => 800, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Овощная смесь, 400 г', 'description' => 'Брокколи, морковь, цветная капуста.', 'price' => 159, 'weight_grams' => 400, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Пломбир ванильный, 450 г', 'description' => 'Сливочное мороженое в контейнере.', 'price' => 269, 'weight_grams' => 450, 'image' => '/images/dishes/default.svg'],
                        ],
                    ],
                ],
                'reviews' => [
                    ['user' => 'anna', 'rating' => 5, 'comment' => 'Хороший выбор готовой еды и адекватные цены.'],
                    ['user' => 'ivan', 'rating' => 4, 'comment' => 'Нормальная доставка, часто беру воду и заморозку.'],
                ],
            ],
            [
                'restaurant' => [
                    'name' => 'Чижик',
                    'slug' => 'chizhik',
                    'description' => 'Дискаунтер с упором на выгодные цены и базовые продукты на неделю.',
                    'cuisine' => 'Дискаунтер',
                    'address' => 'Самара, ул. Дачная, 2',
                    'delivery_time' => 48,
                    'delivery_fee' => 59,
                    'min_order_amount' => 600,
                    'rating' => 4.4,
                    'image' => '/images/restaurants/chizhik.svg',
                    'is_active' => true,
                ],
                'categories' => [
                    [
                        'name' => 'Мясо и птица',
                        'slug' => 'meat-poultry',
                        'sort_order' => 1,
                        'dishes' => [
                            ['name' => 'Филе куриное охлажденное, 1 кг', 'description' => 'Подходит для жарки и запекания.', 'price' => 399, 'weight_grams' => 1000, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Фарш домашний, 500 г', 'description' => 'Смесь говядины и свинины.', 'price' => 249, 'weight_grams' => 500, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Сосиски молочные, 450 г', 'description' => 'Классические сосиски для завтрака.', 'price' => 219, 'weight_grams' => 450, 'image' => '/images/dishes/default.svg'],
                        ],
                    ],
                    [
                        'name' => 'Сыры и колбасы',
                        'slug' => 'deli',
                        'sort_order' => 2,
                        'dishes' => [
                            ['name' => 'Сыр полутвердый 45%, 200 г', 'description' => 'Нарезка для бутербродов и перекусов.', 'price' => 179, 'weight_grams' => 200, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Колбаса докторская, 400 г', 'description' => 'Вареная колбаса для завтраков.', 'price' => 229, 'weight_grams' => 400, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Ветчина куриная, 300 г', 'description' => 'Нежная ветчина в вакуумной упаковке.', 'price' => 199, 'weight_grams' => 300, 'image' => '/images/dishes/default.svg'],
                        ],
                    ],
                    [
                        'name' => 'Крупы и консервация',
                        'slug' => 'staples',
                        'sort_order' => 3,
                        'dishes' => [
                            ['name' => 'Гречка ядрица, 900 г', 'description' => 'Быстрый гарнир на каждый день.', 'price' => 119, 'weight_grams' => 900, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Тунец в собственном соку, 185 г', 'description' => 'Консервы для салатов и сэндвичей.', 'price' => 149, 'weight_grams' => 185, 'image' => '/images/dishes/default.svg'],
                            ['name' => 'Фасоль красная, 400 г', 'description' => 'Консервированная фасоль в томатном соусе.', 'price' => 99, 'weight_grams' => 400, 'image' => '/images/dishes/default.svg'],
                        ],
                    ],
                ],
                'reviews' => [
                    ['user' => 'maria', 'rating' => 5, 'comment' => 'В Чижике реально выгодно брать базовые продукты.'],
                    ['user' => 'anna', 'rating' => 4, 'comment' => 'Доставка не самая быстрая, но цены отличные.'],
                ],
            ],
        ];

        foreach ($catalog as $item) {
            $restaurant = Restaurant::query()->updateOrCreate(
                ['slug' => $item['restaurant']['slug']],
                $item['restaurant']
            );
            $createdDishes = collect();

            foreach ($item['categories'] as $categoryData) {
                $dishes = $categoryData['dishes'];
                unset($categoryData['dishes']);

                $category = $restaurant->categories()->updateOrCreate(
                    ['slug' => $categoryData['slug']],
                    $categoryData
                );

                foreach ($dishes as $dishData) {
                    $createdDishes->push(
                        $category->dishes()->updateOrCreate(
                            ['name' => $dishData['name']],
                            $dishData + ['restaurant_id' => $restaurant->id]
                        )
                    );
                }
            }

            foreach ($item['reviews'] as $reviewData) {
                $restaurant->reviews()->updateOrCreate([
                    'user_id' => $users[$reviewData['user']]->id,
                    'comment' => $reviewData['comment'],
                ], [
                    'rating' => $reviewData['rating'],
                ]);
            }

            if ($restaurant->slug !== 'pizza-district') {
                continue;
            }

            $customer = $users['anna'];
            $alreadyHasSeedOrder = $customer->orders()
                ->where('restaurant_id', $restaurant->id)
                ->exists();

            if ($alreadyHasSeedOrder) {
                continue;
            }

            $selectedDishes = $createdDishes->take(2);

            if ($selectedDishes->isEmpty()) {
                continue;
            }

            $subtotal = $selectedDishes->sum('price');

            $order = $customer->orders()->create([
                'restaurant_id' => $restaurant->id,
                'status' => 'new',
                'delivery_address' => $customer->default_address,
                'customer_phone' => $customer->phone,
                'comment' => 'Позвонить за 5 минут до приезда.',
                'total_amount' => $subtotal + $restaurant->delivery_fee,
                'delivery_fee' => $restaurant->delivery_fee,
                'ordered_at' => now(),
            ]);

            foreach ($selectedDishes as $dish) {
                $order->items()->create([
                    'dish_id' => $dish->id,
                    'dish_name' => $dish->name,
                    'quantity' => 1,
                    'price' => $dish->price,
                ]);

                Cart::query()->updateOrCreate(
                    ['user_id' => $customer->id, 'dish_id' => $dish->id],
                    ['quantity' => 1, 'price' => $dish->price]
                );
            }
        }
    }
}
