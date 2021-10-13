<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoriesSections = ['App\Models\Blog', 'App\Models\News', 'App\Models\Gallery'];

        for($i = 100; $i > 0; $i--)
        {
            DB::table('categoryables')->insert([
                'category_id' => rand(1, 20),
                'categoryable_id' => rand(1, 20),
                'categoryable_type' => $categoriesSections[array_rand($categoriesSections)]
            ]);

            DB::table('status_user')->insert([
                'status_id' => rand(1, 4),
                'user_id' => rand(1, 100),
            ]);
        }
    }
}
