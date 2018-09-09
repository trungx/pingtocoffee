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

$factory->define(App\Reminder::class, function (Faker $faker) {
    $frequency_types = ['day', 'week', 'month', 'year'];
    return [
        'from_user_id' => \App\User::first()->id,
        'to_user_id' => \App\User::all()->random()->id,
        'title' => $faker->sentence(6),
        'frequency_type' => $frequency_types[mt_rand(0, count($frequency_types) - 1)],
        'frequency_number' => rand(1, 255),
        'next_expected_date' => now()->addDays(7)
    ];
});
