<?php

$factory->define(App\Models\AppDocument::class, function () {
    return [
        'app_id' => function () {
            return factory(App\Models\App::class)->create()->id;
        }
    ];
});

$factory->state(App\Models\AppDocument::class, 'file', function (Faker\Generator $faker) {
    return [
        'type'     => $faker->numberBetween(1, 2),
        'metadata' => [
            'title'       => $faker->sentence,
            'description' => $faker->sentences
        ]
    ];
});

$factory->state(App\Models\AppDocument::class, 'eSignature', function (Faker\Generator $faker) {
    return [
        'type'     => 3,
        'metadata' => [
            'title'       => $faker->sentence,
            'description' => $faker->sentences,
            'person'      => $faker->name
        ]
    ];
});
