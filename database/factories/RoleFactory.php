<?php

$factory->define(App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name'         => $faker->word,
        'display_name' => $faker->word,
        'description'  => $faker->sentence,
        'is_system'    => $faker->boolean
    ];
});

$factory->state(App\Models\Role::class, 'super_admin', function () {
    return [
        'name'         => 'super_admin',
        'display_name' => 'Super admin',
        'is_system'    => true
    ];
});

$factory->state(App\Models\Role::class, 'admin', function () {
    return [
        'name'         => 'admin',
        'display_name' => 'Board admin',
        'is_system'    => true
    ];
});

$factory->state(App\Models\Role::class, 'member', function () {
    return [
        'name'         => 'member',
        'display_name' => 'Member',
        'is_system'    => true
    ];
});
