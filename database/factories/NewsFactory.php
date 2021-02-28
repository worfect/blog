<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\News;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(News::class, function (Faker $faker) {

    $title = $faker->text(rand(20, 50));
    $text = $faker->realText(rand(500, 1000));
    $userId = rand(1, 100);


    return [
        'title' => $title,
        'excerpt' => Str::limit($text, 200),
        'text' => $text,
        'user_id' => $userId,
        'image' => $faker->imageUrl($width = 800, $height = 600),
        'rating' => rand(1, 100),
        'views' => rand(1, 1000)
    ];
});
