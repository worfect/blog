<?php

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->text(rand(20, 50));
        $text = $this->faker->realText(rand(500, 1000));
        $userId = rand(1, 100);

        return [
            'title' => $title,
            'excerpt' => Str::limit($text, 200),
            'text' => $text,
            'user_id' => $userId,
            'image' => $this->faker->imageUrl(800, 600),
            'views' => rand(1, 1000)
        ];
    }
}
