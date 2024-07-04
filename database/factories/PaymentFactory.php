<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Payment;
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

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'amount' => $faker->randomElement([30,50,60]),
        'user_id' => '1',
        'ad_id' => rand(1,20),
        'package_id' => $faker->randomElement([1, 2]),
        'payment_intent_id'=> 'test'.rand(100000,999999),
        'payment_customer_id'=> 'test'.rand(100000,999999),
        'paid_on' => '2020-03-18 21:30:58',
        'renew_on' => '2020-04-18 21:30:58',
    ];
});
