<?php

$factory->define(App\Models\AppChecklist::class, function (Faker\Generator $faker) {
    return [
        'app_id' => function () {
            return factory(App\Models\App::class)->create()->id;
        },
        'body'   => $faker->sentence
    ];
});
