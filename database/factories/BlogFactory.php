<?php

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->text(rand(20, 50));
        $text = $this->faker->realText(rand(500, 1000));
        $userId = rand(1, 100);

        return [
            'title' => $title,
            'excerpt' => Str::limit($text, 150),
            'text' => $text,
            'user_id' => $userId,
            'image' => $this->faker->imageUrl(640, 480),
            'views' => rand(1, 1000)
        ];
    }
}
