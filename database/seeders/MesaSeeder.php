<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesaSeeder extends Seeder
{
    
    public function run(): void
    {
        DB::table('mesas')->insert([
            ['nombre' => 'Mesa 1', 'barra' => false],
            ['nombre' => 'Barra A', 'barra' => true],
            ['nombre' => 'Mesa 2', 'barra' => false],
            ['nombre' => 'Mesa 3', 'barra' => false],
            ['nombre' => 'Mesa 4', 'barra' => false],
            ['nombre' => 'Mesa 5', 'barra' => false],
        ]);
    }
}
