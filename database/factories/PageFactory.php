<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    $page_type = $faker->randomELement(["Top Level", "Categories", "Location"]);
    if ($page_type == "Categories") {
        $category_id = $faker->randomElement([1,2,3,4,5,6,7,8,9,10]);
        $location_id = null;
    } else if($page_type == "Location") {
        $category_id = null;
        $location_id = $faker->randomElement([1,2,3,4,5,6,7,8,9,10]);
    } else {
        $category_id = null;
        $location_id = null;
    }
    $cms_name = $faker->unique()->name;
    return [
    		"cms_title" => $faker->name,
            "cms_name" => $cms_name,
            "cms_slug" => str_slug($cms_name),
            "cms_description" => $faker->randomElement(["lorem ipsum skehvns","jdksinfj lorshf","sdihdihd dgjhie"]),
            "category_id" => $category_id,
            "location_id" => $location_id,
            "page_type" => $page_type,  
    ];
});
