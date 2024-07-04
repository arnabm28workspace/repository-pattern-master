<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Ads;
use Faker\Generator as Faker;

$factory->define(Ads::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'slug' => strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $faker->name)),
        'description' => $faker->text,
        'unique_id' => $faker->randomNumber(6),
        'category_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9,10]),
        'country_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9,10]),
        'city'  => $faker->city,
        'type'  => $faker->randomElement([1,2]),
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'website'   => $faker->url,
        'user_id'   => $faker->randomElement([1,2,3,4,5,6,7,8,9,10]),
        'price' => $faker->randomNumber(2),
        'is_blocked'    => $faker->randomElement([true, false]),
        'created_at'    => \Carbon\Carbon::now()
    ];
});
