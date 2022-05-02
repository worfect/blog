<?php

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;

class AttitudeFactory extends Factory
{
    public function definition()
    {
        $sections = ['App\Models\Blog', 'App\Models\News', 'App\Models\Gallery', 'App\Models\Comment'];

        return [
            'user_id' => rand(1, 100),
            'attitudeable_id' => rand(1, 100),
            'attitudeable_type' => $sections[array_rand($sections)],
            'attitude' => rand(0, 1),
        ];
    }
}
