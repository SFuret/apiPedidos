<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PedidoSuministroSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pedido_suministro')->insert([
            [
                'pedido_id' => 1,
                'suministro_id' => 1,
                'cantidad' => 5,
                'notas' => 'Sin sal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pedido_id' => 1,
                'suministro_id' => 2,
                'cantidad' => 2,
                'notas' => 'Con hielo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pedido_id' => 2,
                'suministro_id' => 3,
                'cantidad' => 1,
                'notas' => 'Extra de queso',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'pedido_id' => 3,
                'suministro_id' => 1,
                'cantidad' => 4,
                'notas' => 'Sin observaciones',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
