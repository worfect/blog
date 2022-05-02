<?php

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->text(rand(20, 50));
        $customer = $this->faker->company;
        $link = $this->faker->url;
        $text = $this->faker->realText(rand(500, 700));

        return [
            'title' => $title,
            'text' => $text,
            'customer' => $customer,
            'link' => $link,
            'image' => $this->faker->imageUrl(800, 600),
        ];
    }
}
