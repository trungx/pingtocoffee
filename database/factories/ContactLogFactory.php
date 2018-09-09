<?php

use Faker\Generator as Faker;
use App\User;
use App\Relationship;
use App\ContactType;

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

$factory->define(App\ContactLog::class, function (Faker $faker) {
    do {
        $fromUser = User::first();
        $toUser = User::all()->random();
        $isInRelationship = Relationship::where(['user_first_id' => $fromUser->id, 'user_second_id' => $toUser->id])->count();
    } while ($fromUser->id == $toUser->id || $fromUser->id > $toUser->id || $isInRelationship == 0);

    return [
        'from_user_id' => $fromUser->id,
        'to_user_id' => $toUser->id,
        'contact_type' => ContactType::all()->random()->id,
        'contact_time' => $faker->dateTime(),
        'notes' => $faker->text(),
    ];
});
