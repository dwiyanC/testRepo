<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Inventory2;
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

$factory->define(Inventory2::class, function (Faker $faker) {
    return [
        'unit_name' => $faker->word,
        'unit_type' => $faker->text($maxNbChars = 7),
        'unit_no' => $faker->numberBetween($min = 10, $max = 50),
    ];
});
