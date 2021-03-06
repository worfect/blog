<?php

/** @var Factory $factory */

use \App\Models\Gallery;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Gallery::class, function (Faker $faker) {

    $title = $faker->text(rand(20, 50));
    $text = $faker->realText(rand(100, 150));
    $userId = rand(1, 10);

    return [
        'title' => $title,
        'text' => $text,
        'user_id' => $userId,
        'image' => $faker->imageUrl($width = 800, $height = 600),
        'views' => rand(1, 1000)
    ];
});
