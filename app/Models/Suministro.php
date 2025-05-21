<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suministro extends Model
{
    use HasFactory;
   // protected $table = 'suministro';

    protected $fillable = [
        //'numPedido',
        'nombre',
        'precio',
        'categoria',
        'detalles',
        'ingredientes',
        'marca',
        'fechaCaducidad',
        'fechaAlta',
        'cantidad',
        'ubicacion'
    ];


}
