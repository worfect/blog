<?php

declare(strict_types=1);

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class NewsFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->text(random_int(20, 50));
        $text = $this->faker->realText(random_int(500, 1000));
        $userId = random_int(1, 100);

        return [
            'title' => $title,
            'excerpt' => Str::limit($text, 200),
            'text' => $text,
            'user_id' => $userId,
            'image' => $this->faker->imageUrl(800, 600),
            'views' => random_int(1, 1000),
        ];
    }
}
