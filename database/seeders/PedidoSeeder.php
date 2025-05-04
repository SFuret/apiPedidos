<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        // Asegúrate de que existan mesas y usuarios antes de esto
        for ($i = 1; $i <= 10; $i++) {
            Pedido::create([
                'idMesa' => rand(1, 5),       // Asumiendo que hay al menos 5 mesas
                'idUsuario' => rand(1, 3),    // Asumiendo que hay al menos 3 usuarios
                'estado' => 'pendiente',      // Puedes variar esto si quieres
               
            ]);
        }
    }
}
