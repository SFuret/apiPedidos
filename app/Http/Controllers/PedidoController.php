<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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

    //Agregar un pedido completo con suministros incluídos
    public function crearPedidoConSuministros(Request $request): JsonResponse
{
    $validated = $request->validate([
        'idMesa'      => 'required|exists:mesas,id',
        'idUsuario'   => 'required|exists:users,id',
        'estado'      => 'required|string|max:50',
        'suministros' => 'required|array|min:1',
        'suministros.*.suministro_id' => 'required|exists:suministros,id',
        'suministros.*.cantidad'      => 'required|integer|min:1',
        'suministros.*.notas'         => 'nullable|string',
    ]);

    DB::beginTransaction();
    try {
        // 1. Crear el pedido
        $pedido = Pedido::create([
            'idMesa'    => $validated['idMesa'],
            'idUsuario' => $validated['idUsuario'],
            'estado'    => $validated['estado'],
        ]);

        // 2. Asociar los suministros
        foreach ($validated['suministros'] as $item) {
            $pedido->suministros()->attach($item['suministro_id'], [
                'cantidad' => $item['cantidad'],
                'notas'    => $item['notas'] ?? null,
            ]);
        }

        DB::commit();

        // Cargar suministros y devolver respuesta
        $pedido->load('suministros');

        $datos = $pedido->suministros->map(function ($s) {
            return [
                'id'       => $s->id,
                'nombre'   => $s->nombre,
                'precio'   => $s->precio,
                'cantidad' => $s->pivot->cantidad,
                'notas'    => $s->pivot->notas,
                'total'    => round($s->precio * $s->pivot->cantidad, 2),
            ];
        });

        return response()->json([
           // 'pedido'      => $pedido->codigo, // ← Usa el accessor
            'pedido'      => $pedido->noPedido,
            'suministros' => $datos,
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => 'Error al crear el pedido',
            'detalle' => $e->getMessage(),
        ], 500);
    }
}




     // GET /api/pedidos/{noPedido}/suministros
     public function suministros($noPedido): JsonResponse
     {
         $pedido = Pedido::with('suministros')->findOrFail($noPedido);

         $datos = $pedido->suministros->map(function ($s) {
             return [
                 'id'       => $s->id,
                 'nombre'   => $s->nombre,
                 'precio'   => $s->precio,
                 'cantidad' => $s->pivot->cantidad,
                 'notas'    => $s->pivot->notas,
                 'total'    => round($s->precio * $s->pivot->cantidad, 2),
             ];
         });

         return response()->json([
             'pedido'      => $pedido->noPedido,
             'suministros' => $datos,
         ]);
     }


     //POST Agregar 1 suministro a un pedido existente
     public function agregarSuministro(Request $request, $pedidoId)
     {
         $request->validate([
             'suministro_id' => 'required|exists:suministros,id',
             'cantidad' => 'required|integer|min:1',
             'notas' => 'nullable|string',
         ]);

         $pedido = Pedido::findOrFail($pedidoId);

         $pedido->suministros()->attach($request->suministro_id, [
             'cantidad' => $request->cantidad,
             'notas' => $request->notas,
         ]);

         return response()->json(['message' => 'Suministro añadido correctamente'], 201);
     }

       //POST  Agregar varios suministro a la vez a un pedido existente
     public function agregarSuministros(Request $request, $pedidoId)
     {
         $request->validate([
             'suministros' => 'required|array|min:1',
             'suministros.*.suministro_id' => 'required|exists:suministros,id',
             'suministros.*.cantidad' => 'required|integer|min:1',
             'suministros.*.notas' => 'nullable|string',
         ]);

         $pedido = Pedido::findOrFail($pedidoId);

         foreach ($request->suministros as $item) {
             $pedido->suministros()->attach($item['suministro_id'], [
                 'cantidad' => $item['cantidad'],
                 'notas' => $item['notas'] ?? null,
             ]);
         }

         return response()->json(['message' => 'Suministros añadidos correctamente'], 201);
     }

     //DELETE Eliminar un suministro de un pedido existente
     public function eliminarSuministro($pedidoId, $suministroId)
        {
            $pedido = Pedido::findOrFail($pedidoId);

            // Verificamos si existe la relación
            if (!$pedido->suministros()->where('suministro_id', $suministroId)->exists()) {
                return response()->json(['message' => 'Suministro no encontrado en el pedido'], 404);
            }

            // Desvincula el suministro del pedido
            $pedido->suministros()->detach($suministroId);

            return response()->json(['message' => 'Suministro eliminado del pedido correctamente']);
        }

    }


