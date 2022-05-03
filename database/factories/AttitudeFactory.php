<?php

declare(strict_types=1);

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;

final class AttitudeFactory extends Factory
{
    public function definition()
    {
        $sections = ['App\Models\Blog', 'App\Models\News', 'App\Models\Gallery', 'App\Models\Comment'];

        return [
            'user_id' => random_int(1, 100),
            'attitudeable_id' => random_int(1, 100),
            'attitudeable_type' => $sections[array_rand($sections)],
            'attitude' => random_int(0, 1),
        ];
    }
}
