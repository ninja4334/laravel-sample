<?php

$factory->define(App\Models\AppType::class, function (Faker\Generator $faker) {
    return [
        'board_id' => function () {
            return factory(App\Models\Board::class)->create()->id;
        },
        'name'     => $faker->sentence,
        'acronym'  => $faker->word
    ];
});
