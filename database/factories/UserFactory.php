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

$factory->define(App\User::class, function (Faker $faker) {
    $colors = [
        '#fdb660',
        '#93521e',
        '#bd5067',
        '#b3d5fe',
        '#ff9807',
        '#709512',
        '#5f479a',
        '#e5e5cd',
    ];

    // Create a new account
    $account = new \App\Account();
    $account->save();

    $firstName = $faker->firstName;
    $lastName = $faker->lastName;

    return [
        'account_id' => $account->id,
        'first_name' => $firstName,
        'last_name' => $lastName,
        'username' => \App\User::generateUniqueUsername($firstName . " " . $lastName),
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('secret'),
        'remember_token' => str_random(10),
        'default_avatar_color' => $colors[mt_rand(0, count($colors) - 1)],
        'referral_code' => \App\User::randomCode(),
    ];
});
