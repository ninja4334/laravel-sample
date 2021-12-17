<?php

$factory->define(App\Models\App::class, function (Faker\Generator $faker) {
    return [
        'board_id'      => function () {
            return factory(App\Models\Board::class)->create()->id;
        },
        'type_id'       => function () {
            return factory(App\Models\AppType::class)->create()->id;
        },
        'profession_id' => function () {
            return factory(App\Models\BoardProfession::class)->create()->id;
        },
        'title'         => $faker->sentence,
        'price'         => $faker->randomFloat(null, 10, 500),
        'renewal_years' => $faker->randomDigit,
        'renewal_date'  => $faker->dateTimeBetween('now', '+2 years'),
        'filling_stage' => $faker->numberBetween(1, 5),
        'approved_text' => $faker->sentences(5, true),
        'is_active'     => $faker->boolean
    ];
});
