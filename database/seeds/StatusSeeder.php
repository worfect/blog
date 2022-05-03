<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

final class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        $status = ['wait', 'active', 'banned', 'deleted'];

        foreach ($status as $name) {
            DB::table('statuses')->insert([
                'name' => $name,
            ]);
        }
    }
}
