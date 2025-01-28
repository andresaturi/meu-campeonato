<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChampionshipsTableSeeder extends Seeder
{
    public function run()
    {
        $championships = [
            ['name' => 'Campeonato 1'],
            ['name' => 'Campeonato 2'],           
        ];

        DB::table('championships')->insert($championships);
    }
}
