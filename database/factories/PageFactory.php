<?php

$factory->define(App\Models\Page::class, function (Faker\Generator $faker) {
    $description = implode('', array_map(function () use ($faker) {
        return '<p>' . $faker->paragraph(10) . '</p>';
    }, range(0, 10)));

    return [
        'slug'             => $faker->word,
        'title'            => $faker->sentence,
        'description'      => $description,
        'meta_title'       => $faker->sentences(3, true),
        'meta_description' => $faker->sentences(3, true),
        'is_active'        => $faker->boolean,
        'is_system'        => $faker->boolean,
    ];
});
