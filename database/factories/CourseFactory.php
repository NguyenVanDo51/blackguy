<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Models\Course::class, function (Faker $faker) {
    $courses = ['Ruby', 'Javascript', 'PHP', 'C++', 'Java'];
    return [
        'name' => $faker->randomElement($courses) . $faker->text(20),
        'description' => $faker->text(150)
    ];
});
