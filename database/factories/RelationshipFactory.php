<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Relationship::class, function (Faker $faker) {
    $userFirst = \App\User::first();
    do {
        $userSecond = \App\User::all()->random();
        $sortedUsers = collect([$userFirst, $userSecond])->sortBy('id');
        $existedRelationship = \App\Relationship::where([
            'user_first_id' => $sortedUsers->first()->id,
            'user_second_id' => $sortedUsers->last()->id
        ])->exists();
    } while ($userFirst->id == $userSecond->id || $existedRelationship);

    $type = $faker->randomElement([
        \App\Relationship::FRIENDS_TYPE,
        \App\Relationship::PENDING_SECOND_FIRST_TYPE,
        \App\Relationship::PENDING_FIRST_SECOND_TYPE
    ]);

    if ($type == \App\Relationship::FRIENDS_TYPE) {
        // Create event log
        $userFirst->createLogForFeed($userSecond->id, $userFirst->id, \App\Event::ADD_ACTION);
    }

    return [
        'user_first_id' => $userFirst->id,
        'user_second_id' => $userSecond->id,
        'type' => $type,
    ];
});
