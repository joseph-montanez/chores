<?php

use Faker\Generator as Faker;

$factory->define(App\Worker::class, function (Faker $faker) {
    $user = factory(App\User::class)->create();
    return [
        'name' => $user->name,
        'owner_id' => function () use ($user) {
            return $user->id;
        },
        'user_id' => function () use ($user) {
            return $user->id;
        }
    ];
});
