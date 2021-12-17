<?php

$factory->define(App\Models\Settings::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->word,
        'display_name' => $faker->word,
        'value'        => $faker->word
    ];
});
