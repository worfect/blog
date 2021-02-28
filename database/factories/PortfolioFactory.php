<?php

/** @var Factory $factory */

use \App\Models\Portfolio;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;


$factory->define(Portfolio::class, function (Faker $faker) {

    $title = $faker->text(rand(20, 50));
    $customer = $faker->company;
    $link = $faker->url;
    $text = $faker->realText(rand(500, 700));

    return [
        'title' => $title,
        'text' => $text,
        'customer' => $customer,
        'link' => $link,
        'image' => $faker->imageUrl($width = 800, $height = 600),
    ];
});
