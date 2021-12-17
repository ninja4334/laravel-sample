<?php

$factory->define(App\Models\AppStatus::class, function (Faker\Generator $faker) {
    return [
        'board_id'   => function () {
            return factory(App\Models\Board::class)->create()->id;
        },
        'name'       => $faker->word,
        'message'    => $faker->sentences(3, true),
        'is_auto'    => $faker->boolean,
        'is_default' => $faker->boolean,
    ];
});

$factory->state(App\Models\AppStatus::class, 'submitted', function () {
    return [
        'board_id'    => null,
        'system_name' => 'submitted',
        'name'        => 'Submitted',
        'is_auto'     => true,
        'is_default'  => true,
    ];
});

$factory->state(App\Models\AppStatus::class, 'approved', function () {
    return [
        'board_id'    => null,
        'system_name' => 'approved',
        'name'        => 'Approved',
        'is_auto'     => true,
        'is_default'  => true,
    ];
});

$factory->state(App\Models\AppStatus::class, 'denied', function () {
    return [
        'board_id'    => null,
        'system_name' => 'denied',
        'name'        => 'Denied',
        'is_auto'     => true,
        'is_default'  => true,
    ];
});

$factory->state(App\Models\AppStatus::class, 'deferred', function () {
    return [
        'board_id'    => null,
        'system_name' => 'deferred',
        'name'        => 'Deferred',
        'is_auto'     => true,
        'is_default'  => true,
    ];
});
