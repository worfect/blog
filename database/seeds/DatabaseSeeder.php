<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Attitude;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\Layouts\Banner;
use App\Models\News;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     */
    public function run(): void
    {
        User::factory()->count(100)->create();

        Portfolio::factory()->count(8)->create();
        Blog::factory()->count(100)->create();
        Gallery::factory()->count(100)->create();
        News::factory()->count(100)->create();

        Category::factory()->count(20)->create();
        Comment::factory()->count(100)->create();
        Attitude::factory()->count(100)->create();

        Banner::factory()->count(3)->create();

        $this->call(RelationSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
