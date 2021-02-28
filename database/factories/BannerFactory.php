<?php

/** @var Factory $factory */

use App\Models\Layouts\Banner;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Banner::class, function (Faker $faker) {

    $title = $faker->text(rand(10, 20));
    $desc = $faker->realText(10);
    $img =  $faker->imageUrl($width = 800, $height = 600);

    return [
        'title' => $title,
        'img' => $img,
        'desc' => $desc,
    ];

});
