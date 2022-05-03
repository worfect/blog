<?php

declare(strict_types=1);

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;

final class GalleryFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->text(random_int(20, 50));
        $text = $this->faker->realText(random_int(100, 150));
        $userId = random_int(1, 10);

        return [
            'title' => $title,
            'text' => $text,
            'user_id' => $userId,
            'image' => $this->faker->imageUrl(800, 600),
            'views' => random_int(1, 1000),
        ];
    }
}
