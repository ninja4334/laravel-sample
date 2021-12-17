<?php

$factory->define(App\Models\State::class, function (Faker\Generator $faker) {
    return [
        'abbreviation' => $faker->stateAbbr,
        'name'         => $faker->state
    ];
});
