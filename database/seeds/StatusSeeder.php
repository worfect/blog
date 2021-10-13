<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = ['wait', 'active', 'banned', 'deleted'];

        foreach($status as $name)
        {
            DB::table('statuses')->insert([
                'name' => $name
            ]);
        }
    }
}
