<?php

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;


class CategoryFactory extends Factory
{
    public function definition()
    {
        $name = $this->faker->unique()->word;

        return [
            'name' => $name,
        ];
    }
}
