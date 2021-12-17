<?php

$factory->define(App\Models\AppCertificate::class, function (Faker\Generator $faker) {
    return [
        'app_id'          => function () {
            return factory(App\Models\App::class)->create()->id;
        },
        'name'            => $faker->sentence,
        'email'           => $faker->email,
        'phone'           => $faker->phoneNumber,
        'signature_name'  => $faker->name,
        'signature_title' => $faker->sentence
    ];
});
