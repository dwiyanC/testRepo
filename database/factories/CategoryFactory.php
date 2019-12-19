<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'type_names' => $faker->text($maxNbChars = 5),
        'description' => $faker->text($maxNbChars = 8),
    ];
});
