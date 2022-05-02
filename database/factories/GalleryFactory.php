<?php

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->text(rand(20, 50));
        $text = $this->faker->realText(rand(100, 150));
        $userId = rand(1, 10);

        return [
            'title' => $title,
            'text' => $text,
            'user_id' => $userId,
            'image' => $this->faker->imageUrl(800, 600),
            'views' => rand(1, 1000)
        ];
    }
}
