<?php

/** @var Factory $factory */


use App\Models\Comment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Comment::class, function (Faker $faker) {

    $text = $faker->realText(rand(100, 300));
    $userId = rand(1, 100);

    return [
        'text' => $text,
        'rating' => rand(1, 100),
        'user_id' => $userId,
    ];
});
