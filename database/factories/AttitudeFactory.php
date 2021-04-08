<?php

/** @var Factory $factory */


use App\Models\Attitude;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Attitude::class, function (Faker $faker) {

    $sections = ['App\Models\Blog', 'App\Models\News', 'App\Models\Gallery', 'App\Models\Comment'];

    return [
        'user_id' => rand(1, 100),
        'attitudeable_id' => rand(1, 100),
        'attitudeable_type' => $sections[array_rand($sections)],
        'attitude' => rand(0, 1),
    ];
});
