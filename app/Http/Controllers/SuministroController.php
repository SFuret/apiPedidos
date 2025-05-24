<?php

namespace App\Http\Controllers;

use App\Models\PedidoSuministro;
use App\Models\Suministro;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SuministroController extends Controller
{
    // public function index(): JsonResponse
    // {
    //     return response()->json(Suministro::all());
    // }
public function index(): JsonResponse
{
    $suministros = Suministro::all()->map(function ($s) {
        return [
            'id' => $s->id,
            'nombre' => $s->nombre,
            'precio' => $s->precio,
            'categoria' => $s->categoria,
            'detalles' => $s->detalles,
            'marca' => $s->marca,
            'fechaCaducidad' => $s->fechaCaducidad,
            'cantidad' => $s->cantidad,
            'ubicacion' => $s->ubicacion,
            'fechaAlta' => $s->created_at ? $s->created_at->format('Y-m-d H:i') : null,
            'última actualización' => $s->updated_at ? $s->updated_at->format('Y-m-d H:i') : null,
        ];
    });

    return response()->json($suministros);
}
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
           // 'numPedido' => 'required|string|unique:suministros',
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric',
            'categoria' => 'nullable|string|max:50',
            'detalles' => 'nullable|string',
            'ingredientes' => 'nullable|string',
            'marca' => 'nullable|string|max:50',
            'fechaCaducidad' => 'nullable|date',
            'fechaAlta' => 'nullable|date',
            'cantidad' => 'required|integer|min:1',
            'ubicacion' => 'required|in:bar,cocina',
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
            'nombre' => 'sometimes|string|max:100',
            'precio' => 'sometimes|numeric',
            'categoria' => 'nullable|string|max:50',
            'detalles' => 'nullable|string',
            'ingredientes' => 'nullable|string',
            'marca' => 'nullable|string|max:50',
            'fechaCaducidad' => 'nullable|date',
            'fechaAlta' => 'nullable|date',
            'cantidad' => 'required|integer|min:1', //obliga a que sea un valor entero positivo o vacío
            'ubicacion' => 'nullable|in:bar,cocina',
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

    //obtener las distintas categorias
   public function obtenerCategorias(): JsonResponse
    {
     //  $categorias = DB::select('SELECT DISTINCT categoria FROM suministros');
      $categorias = DB::table('suministros')
        ->select('categoria')
        ->distinct()
        ->get()
        ->pluck('categoria');
        return response()->json($categorias);
    }


    public function suministros()
{
    return $this->hasMany(PedidoSuministro::class, 'pedido_id');
}

//obtener todos los suministros de una determinada categoria
public function porCategoria(string $categoria): JsonResponse
{
    $suministros = Suministro::where('categoria', $categoria)->get();

    return response()->json($suministros);
}

}
