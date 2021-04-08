<?php

/** @var Factory $factory */


use App\Models\Comment;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Comment::class, function (Faker $faker) {

    $sections = ['App\Models\Blog', 'App\Models\News', 'App\Models\Gallery'];
    $text = $faker->realText(rand(10, 50));
    $userId = rand(1, 100);

    return [
        'text' => $text,
        'user_id' => $userId,
        'commentable_id' => rand(1, 100),
        'commentable_type' => $sections[array_rand($sections)]
    ];
});
