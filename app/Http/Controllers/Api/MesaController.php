<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mesa;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MesaController extends Controller
{
    // GET /api/mesas

public function index(): JsonResponse
{
    $mesas = Mesa::all()->map(function ($mesa) {
        return [
            'id' => $mesa->id,
            'nombre' => $mesa->nombre,
            'barra' => $mesa->barra ? 'sí' : 'no',
            'fechaAlta' => $mesa->created_at ? $mesa->created_at->format('Y-m-d H:i') : null,
            'última actualización' => $mesa->updated_at ? $mesa->updated_at->format('Y-m-d H:i') : null,
        ];
    });

    return response()->json($mesas);
}
    // public function index(): JsonResponse
    // {
    //     return response()->json(Mesa::all());
    // }

    // POST /api/mesas
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|unique:mesas,nombre',
            'barra' => 'required|boolean',
        ]);

        $mesa = Mesa::create($validated);

        return response()->json($mesa, 201);
    }

    // GET /api/mesas/{id}
    public function show($id): JsonResponse
    {
        $mesa = Mesa::findOrFail($id);
        return response()->json($mesa);
    }

    // PUT /api/mesas/{id}
    public function update(Request $request, $id): JsonResponse
    {
        $mesa = Mesa::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'string|unique:mesas,nombre,' . $mesa->id,
            'barra' => 'boolean',
        ]);

        $mesa->update($validated);

        return response()->json($mesa);
    }

    // DELETE /api/mesas/{id}
    public function destroy($id): JsonResponse
    {
        $mesa = Mesa::findOrFail($id);
        $mesa->delete();

        return response()->json(['message' => 'Mesa eliminada']);
    }
}
