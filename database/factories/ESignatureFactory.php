<?php

$factory->define(App\Models\ESignature::class, function (Faker\Generator $faker) {
    $entity = factory(App\Models\Submission::class)->create();

    return [
        'entity_id'   => $entity->id,
        'entity_type' => get_class($entity),
        'user_id'     => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'ip'          => $faker->ipv4,
        'name'        => $faker->word
    ];
});
