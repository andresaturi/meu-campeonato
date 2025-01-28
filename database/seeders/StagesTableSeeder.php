<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $stages = [
            ['name' => 'quartas'],
            ['name' => 'semi'],           
            ['name' => 'final'],           
            ['name' => 'terceiro'],           
        ];

        DB::table('stage')->insert($stages);
    }
}
