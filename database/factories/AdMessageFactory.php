<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdMessages;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(AdMessages::class, function (Faker $faker) {
    return [
    	'ad_id' => $faker->randomElement([1,2,3,4,5,6]),
        'email' => $faker->unique()->safeEmail,
        'phone' => '0123456789',
        'subject' => $faker->randomElement(["lorem ipsum skehvns","jdksinfj lorshf","sdihdihd dgjhie"]),
        'message' => $faker->randomElement(["lorem ipsum skehvns","jdksinfj lorshf","sdihdihd dgjhie"]),
    ];
});
