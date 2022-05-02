<?php

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition()
    {
        $sections = ['App\Models\Blog', 'App\Models\News', 'App\Models\Gallery'];
        $text = $this->faker->realText(rand(10, 50));
        $userId = rand(1, 100);

        return [
            'text' => $text,
            'user_id' => $userId,
            'commentable_id' => rand(1, 100),
            'commentable_type' => $sections[array_rand($sections)]
        ];
    }
}
