<?php

declare(strict_types=1);

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;

final class CommentFactory extends Factory
{
    public function definition()
    {
        $sections = ['App\Models\Blog', 'App\Models\News', 'App\Models\Gallery'];
        $text = $this->faker->realText(random_int(10, 50));
        $userId = random_int(1, 100);

        return [
            'text' => $text,
            'user_id' => $userId,
            'commentable_id' => random_int(1, 100),
            'commentable_type' => $sections[array_rand($sections)],
        ];
    }
}
