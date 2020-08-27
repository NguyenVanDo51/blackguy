<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Lession;
use Faker\Generator as Faker;

$factory->define(Lession::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'title' => $faker->text(25),
        'video' => 'https://www.youtube.com/watch?v=s37i5W1Bzp8'
    ];
});
