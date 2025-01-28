<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsTableSeeder extends Seeder
{
    public function run()
    {
        $teams = [
            ['name' => 'Time A', 'created_at' => now()],
            ['name' => 'Time B', 'created_at' => now()],
            ['name' => 'Time C', 'created_at' => now()],
            ['name' => 'Time D', 'created_at' => now()],
            ['name' => 'Time E', 'created_at' => now()],
            ['name' => 'Time F', 'created_at' => now()],
            ['name' => 'Time G', 'created_at' => now()],
            ['name' => 'Time H', 'created_at' => now()],
        ];

        DB::table('teams')->insert($teams);
    }
}
