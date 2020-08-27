<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Models\Course::class, function (Faker $faker) {
    return [
        'name' => 'Ruby ' . $faker->text(20),
        'description' => $faker->text(150)
    ];
});
