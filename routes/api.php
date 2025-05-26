<?php

use App\Http\Controllers\Api\MesaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\SuministroController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;




//loguearse y obtener un token
Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Credenciales inválidas'], 401);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'rol' => $user->rol,
        ],
    ]);
});

//protejo las rutas para que solo los usuarios autenticados y con un token válido puedan acceder, el token debe mandarse en las cabeceras de todas las peticiones
Route::middleware('auth:sanctum')->group(function () {
// CRUD de mesas
Route::apiResource('mesas', MesaController::class);

// CRUD de usuarios
Route::apiResource('users', UserController::class);

// CRUD de suministros
Route::apiResource('suministros', SuministroController::class);

// CRUD de pedidos
Route::apiResource('pedidos', PedidoController::class);

//Endpoint crear un pedido completo con suminitros incluídos
Route::post('/pedidos-completos', [PedidoController::class, 'crearPedidoConSuministros']);

//Route::get('pedidos/{id}/suministros', [PedidoController::class, 'suministros']); //obtengo suministros que tiene un pedido
// Endpoint para listar suministros de un pedido:
Route::get('pedidos/{noPedido}/suministros', [PedidoController::class, 'suministros']);

// Para agregar un solo suministro
Route::post('/pedidos/{pedido}/suministros', [PedidoController::class, 'agregarSuministro']);

// Para agregar múltiples suministros
Route::post('/pedidos/{pedido}/suministros/lote', [PedidoController::class, 'agregarSuministros']);

// Eliminar un suministro específico de un pedido
Route::delete('/pedidos/{pedido}/suministros/{suministro}', [PedidoController::class, 'eliminarSuministro']);

//Endpoint para obtener el estado de un pedido
Route::get('/pedidos/{pedido}/estado', [PedidoController::class, 'obtenerEstado']);


//ruta para obtener las categorias de los suministros
Route::get('/categorias', [SuministroController::class, 'obtenerCategorias']);

//obtener sumistros de una categoria
Route::get('/suministros/categoria/{categoria}', [SuministroController::class, 'porCategoria']);


//Obtener los pedidos de bar/cocina según la obicación que le pase
Route::get('/pedidosubicacion', [PedidoController::class, 'listarPedidosPorUbicacion']);

//Obtener los suministros asociados a un pedido (es para mostarlo al cocinero/bar)
Route::get('/pedidodetalles/{id}/detalles', [PedidoController::class, 'detallePedidoPorUbicacion']);

});





