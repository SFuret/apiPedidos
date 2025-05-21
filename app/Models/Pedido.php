<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mesa;
use App\Models\User;

class Pedido extends Model
{
    use HasFactory;

    protected $primaryKey = 'noPedido';
    public $incrementing = true;               // ya viene por defecto, pero lo dejamos explícito
    protected $keyType = 'int';


    protected $fillable = ['idMesa','idUsuario','estado'];


    // Relación con la tabla pivote
    public function pedidoSuministros()
    {
        return $this->hasMany(PedidoSuministro::class, 'pedido_id');
    }

    // Relación directa con suministros a través de la pivote
    public function suministros()
    {
        return $this->belongsToMany(
            Suministro::class,
            'pedido_suministro',
            'pedido_id',
            'suministro_id'
        )->withPivot('cantidad', 'notas')
         ->withTimestamps();
    }

    //para que funcione el mostrar nombre mesa en vez de id y lo mismo con usuario
        public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'idMesa');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }


}
