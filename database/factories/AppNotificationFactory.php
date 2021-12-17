<?php

$factory->define(App\Models\AppNotification::class, function (Faker\Generator $faker) {
    return [
        'type_id' => function () {
            return factory(App\Models\AppType::class)->create()->id;
        },
        'type'    => $faker->randomElement(App\Models\AppNotification::types()),
        'date'    => $faker->dateTimeBetween('now', '+1 years'),
        'title'   => $faker->sentence,
        'body'    => $faker->sentences(3, true),
        'sent_at' => $faker->dateTimeBetween('now', '-1 day')
    ];
});
