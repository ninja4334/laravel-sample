<?php

$factory->define(App\Models\BoardProfession::class, function (Faker\Generator $faker) {
    return [
        'board_id' => function () {
            return factory(App\Models\Board::class)->create()->id;
        },
        'name'     => $faker->sentence
    ];
});
