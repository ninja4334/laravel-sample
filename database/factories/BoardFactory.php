<?php

$factory->define(App\Models\Board::class, function (Faker\Generator $faker) {
    return [
        'state_id'             => function () {
            return factory(App\Models\State::class)->create()->id;
        },
        'title'                => $faker->word,
        'abbreviation'         => $faker->word,
        'address'              => $faker->address,
        'email'                => $faker->safeEmail,
        'phone'                => $faker->phoneNumber,
        'card_fee'             => $faker->randomFloat(2, 1, 10),
        'bank_fee'             => $faker->randomFloat(2, 1, 10),
        'is_required_card_fee' => $faker->boolean,
        'is_required_bank_fee' => $faker->boolean,
        'is_active'            => $faker->boolean
    ];
});
