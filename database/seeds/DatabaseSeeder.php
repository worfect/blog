<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 100)->create();

        factory(\App\Models\Blog::class, 100)->create();
        factory(\App\Models\Gallery::class, 100)->create();
        factory(\App\Models\News::class, 100)->create();
        factory(\App\Models\Portfolio::class, 8)->create();

        factory(\App\Models\Category::class, 20)->create();
        factory(\App\Models\Comment::class, 150)->create();

        factory(\App\Models\Layouts\Banner::class, 2)->create();

        $this->call(RelationSeeder::class);
    }
}
