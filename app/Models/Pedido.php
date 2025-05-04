<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $primaryKey = 'noPedido';
    public $incrementing = true;               // ya viene por defecto, pero lo dejamos explícito
    protected $keyType = 'int';


    protected $fillable = ['idMesa','idUsuario','estado'];

   /* protected static function boot()
    {
        parent::boot();

        static::created(function ($pedido) {
            // Una vez creado y con ID (noPedido) asignado, actualizamos el formato.
            $pedido->noPedido = 'PED-' . str_pad($pedido->noPedido, 4, '0', STR_PAD_LEFT);
            // Desactivar temporalmente el guardado automático de timestamps
            $pedido->timestamps = false;
            $pedido->saveQuietly();
        });
    }*/

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


}
