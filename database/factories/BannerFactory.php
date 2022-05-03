<?php

declare(strict_types=1);

namespace Database\Factories;

/** @var Factory $factory */

use App\Models\Layouts\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

final class BannerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     */
    protected $model = Banner::class;

    public function definition()
    {
        $title = $this->faker->text(random_int(10, 20));
        $desc = $this->faker->realText(10);
        $img =  $this->faker->imageUrl(800, 600);

        return [
            'title' => $title,
            'img' => $img,
            'desc' => $desc,
        ];
    }
}
