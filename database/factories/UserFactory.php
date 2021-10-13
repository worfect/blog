<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {

   $login = $faker->unique()->name;
   $active = $faker->boolean;

    return [
        'login' => $login,
        'screen_name' => $login,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'role' => $active ? $faker->randomElement([User::ROLE_USER, User::ROLE_ADMIN, User::ROLE_MODERATOR]) : User::ROLE_USER,
    ];
});
