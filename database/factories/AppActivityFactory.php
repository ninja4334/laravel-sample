<?php

$factory->define(App\Models\AppActivity::class, function (Faker\Generator $faker) {
    return [
        'app_id'            => function () {
            return factory(App\Models\App::class)->create()->id;
        },
        'education_hours'   => $faker->randomFloat(2, 1, 100),
        'is_files_required' => $faker->boolean
    ];
});
