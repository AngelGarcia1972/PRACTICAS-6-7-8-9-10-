<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Resources\CategoriaResource;
use App\Http\Resources\ProductoResource;

class CategoriaController extends Controller
{
    public function index()
    {
        return CategoriaResource::collection(
            Categoria::with('productos')->get()
        );
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'nombre'      => 'required|string|max:100',
            'slug'        => 'required|string|unique:categorias',
            'descripcion' => 'nullable|string',
        ]);

        return new CategoriaResource(Categoria::create($data));
    }

    public function show(Categoria $categoria)
    {
        return new CategoriaResource(
            $categoria->load('productos')
        );
    }

    public function update(\Illuminate\Http\Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'nombre'      => 'sometimes|string|max:100',
            'slug'        => 'sometimes|string|unique:categorias,slug,'.$categoria->id,
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($data);
        return new CategoriaResource($categoria);
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return response()->json(null, 204);
    }

    public function productos(Categoria $categoria)
    {
        return ProductoResource::collection(
            $categoria->productos()->with('categoria')->get()
        );
    }
}