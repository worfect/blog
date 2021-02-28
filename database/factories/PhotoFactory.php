<?php

/** @var Factory $factory */

use \App\Models\Photo;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Photo::class, function (Faker $faker) {

    $title = $faker->text(rand(20, 50));
    $text = $faker->realText(rand(500, 1000));
    $userId = rand(1, 10);

    return [
        'title' => $title,
        'text' => $text,
        'user_id' => $userId,
        'image' => $faker->imageUrl($width = 800, $height = 600),
        'rating' => rand(1, 100),
        'views' => rand(1, 1000)
    ];
});
