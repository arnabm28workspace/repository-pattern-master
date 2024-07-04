<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        "name" => $faker->unique()->colorName,
        "slug" => str_slug($faker->unique()->colorName),
        "description" => $faker->randomElement(["lorem ipsum skehvns","jdksinfj lorshf","sdihdihd dgjhie"]),
        "featured" => $faker->randomElement([0,1]),
        "menu" => $faker->randomElement([0,1]),
    ];
});
