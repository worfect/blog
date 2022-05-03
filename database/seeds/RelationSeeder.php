<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        $categoriesSections = ['App\Models\Blog', 'App\Models\News', 'App\Models\Gallery'];

        for ($i = 100; $i > 0; $i--) {
            DB::table('categoryables')->insert([
                'category_id' => random_int(1, 20),
                'categoryable_id' => random_int(1, 20),
                'categoryable_type' => $categoriesSections[array_rand($categoriesSections)],
            ]);

            DB::table('status_user')->insert([
                'status_id' => random_int(1, 4),
                'user_id' => random_int(1, 100),
            ]);
        }
    }
}
