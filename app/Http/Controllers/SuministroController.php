<?php

namespace App\Http\Controllers;

use App\Models\Suministro;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SuministroController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Suministro::all());
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'numPedido' => 'required|string|unique:suministros',
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric',
            'categoria' => 'nullable|string|max:50',
            'detalles' => 'nullable|string',
            'ingredientes' => 'nullable|string',
            'marca' => 'nullable|string|max:50',
            'fechaCaducidad' => 'nullable|date',
            'fechaAlta' => 'nullable|date',
            'cantidad' => 'required|integer',
        ]);

        $suministro= Suministro::create($validated);
        return response()->json($suministro, 201);
    }

    public function show($id): JsonResponse
    {
        $suministro = Suministro::findOrFail($id);
        return response()->json($suministro);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $suministro = Suministro::findOrFail($id);
        $validated = $request->validate([
            'numPedido' => 'sometimes|string|unique:suministros,numPedido,' . $suministro->id,
            'nombre' => 'sometimes|string|max:100',
            'precio' => 'sometimes|numeric',
            'categoria' => 'nullable|string|max:50',
            'detalles' => 'nullable|string',
            'ingredientes' => 'nullable|string',
            'marca' => 'nullable|string|max:50',
            'fechaCaducidad' => 'nullable|date',
            'fechaAlta' => 'nullable|date',
            'cantidad' => 'sometimes|integer',
        ]);

        $suministro->update($validated);
        return response()->json($suministro);
    }

    public function destroy($id): JsonResponse
    {
        $suministro= Suministro::findOrFail($id);
        $suministro->delete();
        return response()->json(['message' => 'Suministro eliminado']);
    }
}
