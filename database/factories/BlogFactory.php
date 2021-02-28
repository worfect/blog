<?php

/** @var Factory $factory */

use App\Models\Blog;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Blog::class, function (Faker $faker) {

        $title = $faker->text(rand(20, 50));
        $text = $faker->realText(rand(500, 1000));
        $userId = rand(1, 100);


    return [
        'title' => $title,
        'excerpt' => Str::limit($text, 150),
        'text' => $text,
        'user_id' => $userId,
        'image' => $faker->imageUrl($width = 640, $height = 480),
        'rating' => rand(1, 100),
        'views' => rand(1, 1000)
    ];
    });
