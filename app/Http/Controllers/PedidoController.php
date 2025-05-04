<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PedidoController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Pedido::all());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'idMesa' => 'required|integer|exists:mesas,id',
            'idUsuario' => 'required|integer|exists:users,id',
            'estado' => 'required|string|max:50',
          //  'fechaAlta' => 'nullable|date'
        ]);

        $pedido = Pedido::create($validated);
        return response()->json($pedido, 201);
    }

    public function show($id): JsonResponse
    {
        $pedido = Pedido::findOrFail($id);
        return response()->json($pedido);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $pedido = Pedido::findOrFail($id);

        $validated = $request->validate([
            'idMesa' => 'sometimes|integer|exists:mesas,id',
            'idUsuario' => 'sometimes|integer|exists:users,id',
            'estado' => 'sometimes|string|max:50',
           // 'fechaAlta' => 'nullable|date'
        ]);

        $pedido->update($validated);
        return response()->json($pedido);
    }

    public function destroy($id): JsonResponse
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return response()->json(['message' => 'Pedido eliminado']);
    }
}
