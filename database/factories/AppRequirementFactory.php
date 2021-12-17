<?php

$factory->define(App\Models\AppRequirement::class, function (Faker\Generator $faker) {
    return [
        'app_id' => function () {
            return factory(App\Models\App::class)->create()->id;
        },
        'title'  => $faker->sentence,
        'hours'  => $faker->numberBetween(1, 20)
    ];
});
