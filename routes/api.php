<?php

use App\Http\Controllers\Api\MesaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\SuministroController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', function (Request $request) {
    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Credenciales inválidas'
        ], 401);
    }

    return response()->json([
        'token' => $user->createToken('api-token')->plainTextToken,
    ]);
});

Route::apiResource('mesas', MesaController::class);

Route::apiResource('users', UserController::class);

Route::apiResource('suministros', SuministroController::class);

Route::apiResource('pedidos', PedidoController::class);

