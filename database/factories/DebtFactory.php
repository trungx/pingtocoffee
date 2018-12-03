<?php

use Faker\Generator as Faker;

$factory->define(\App\Debt::class, function (Faker $faker) {
    do {
        $fromUser = \App\User::first();
        $toUser = \App\User::all()->random();
        $isInRelationship = \App\Relationship::where(['user_first_id' => $fromUser->id, 'user_second_id' => $toUser->id])->count();
    } while ($fromUser->id == $toUser->id || $fromUser->id > $toUser->id || $isInRelationship == 0);

    return [
        'from_user_id' => $fromUser->id,
        'to_user_id' => $toUser->id,
        'in_debt' => $faker->boolean,
        'amount' => $faker->randomNumber(5, true),
        'reason' => $faker->text(),
    ];
});
