<?php

namespace Database\Factories;

/** @var Factory $factory */

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public function definition()
    {
        $login = $this->faker->unique()->name;
        $active = $this->faker->boolean;

        return [
            'login' => $login,
            'screen_name' => $login,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->unique()->phoneNumber,
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'role' => $active ? $this->faker->randomElement([User::ROLE_USER, User::ROLE_ADMIN, User::ROLE_MODERATOR]) : User::ROLE_USER,
        ];
    }
}
