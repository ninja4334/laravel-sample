<?php

$factory->define(App\Models\Permission::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->word,
        'display_name' => $faker->word,
        'description'  => $faker->sentence,
        'is_system'    => $faker->boolean
    ];
});
