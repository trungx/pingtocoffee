<?php

use Faker\Generator as Faker;
use App\Privacy;
use App\User;
use App\ContactField;
use App\DefaultLabel;
use App\ContactFieldValue;

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

$factory->define(ContactFieldValue::class, function (Faker $faker) {
    $contactField = ContactField::all()->random();
    $defaultLabel = DefaultLabel::where('contact_field_type', $contactField->type)->get();
    $privacy = Privacy::all()->random();

    $data = [
        'user_id' => User::all()->random()->id,
        'contact_field_id' => $contactField->id,
        'label_id' => $defaultLabel->random()->id,
        'privacy_id' => $privacy->id,
    ];

    switch ($contactField->type) {
        case \App\ContactField::CONTACT_TYPE_PHONE:
            $data += [
                'value' => $faker->e164PhoneNumber,
            ];
            break;
        case \App\ContactField::CONTACT_TYPE_ADDRESS:
            $data += [
                'value' => $faker->streetAddress,
            ];
            break;
        case \App\ContactField::CONTACT_TYPE_EMAIL:
            $data += [
                'value' => $faker->safeEmail,
            ];
            break;
        case \App\ContactField::CONTACT_TYPE_SOCIAL_PROFILE:
            $data += [
                'value' => $faker->word,
            ];
            break;
        default:
            $data += [
                'value' => $faker->text(20),
            ];
            break;
    }

    return $data;
});
