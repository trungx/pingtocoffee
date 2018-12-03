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

    $email = $faker->unique()->safeEmail;

    return [
        'account_id' => $account->id,
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'username' => \App\User::generateUniqueUsername($email),
        'email' => $email,
        'password' => Hash::make('secret'),
        'timezone' => 'UTC',
        'currency' => 'USD',
        'remember_token' => str_random(10),
        'default_avatar_color' => $colors[mt_rand(0, count($colors) - 1)],
        'referral_code' => \App\User::randomCode(),
        'last_verification_email_sent' => now(),
    ];
});
