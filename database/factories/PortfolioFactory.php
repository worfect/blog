<?php

declare(strict_types=1);

namespace Database\Factories;

/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factories\Factory;

final class PortfolioFactory extends Factory
{
    public function definition()
    {
        $title = $this->faker->text(random_int(20, 50));
        $customer = $this->faker->company;
        $link = $this->faker->url;
        $text = $this->faker->realText(random_int(500, 700));

        return [
            'title' => $title,
            'text' => $text,
            'customer' => $customer,
            'link' => $link,
            'image' => $this->faker->imageUrl(800, 600),
        ];
    }
}
