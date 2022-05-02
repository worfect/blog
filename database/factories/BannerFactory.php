<?php

namespace Database\Factories;

/** @var Factory $factory */

use App\Models\Layouts\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

class BannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Banner::class;

    public function definition()
    {
        $title = $this->faker->text(rand(10, 20));
        $desc = $this->faker->realText(10);
        $img =  $this->faker->imageUrl(800, 600);

        return [
            'title' => $title,
            'img' => $img,
            'desc' => $desc,
        ];

    }
}
