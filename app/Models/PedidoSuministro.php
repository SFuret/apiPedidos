<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoSuministro extends Model
{
    use HasFactory;

    protected $table = 'pedido_suministro';

    protected $fillable = [
        'pedido_id',
        'suministro_id',
        'cantidad',
        'notas',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function suministro()
    {
        return $this->belongsTo(Suministro::class, 'suministro_id');
    }
} 
