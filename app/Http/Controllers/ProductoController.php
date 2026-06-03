<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Resources\ProductoResource;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $productos = Producto::with('categoria')
            ->buscar($request->busqueda)
            ->deCategoria($request->categoria_id)
            ->rangoPrecio($request->precio_min, $request->precio_max)
            ->orderBy($request->get('orden', 'nombre'), $request->get('dir', 'asc'))
            ->paginate($request->get('por_pagina', 15));

        return ProductoResource::collection($productos);
    }

    public function store(StoreProductoRequest $request)
    {
        $this->authorize('create', Producto::class);
        $producto = Producto::create($request->validated());
        return response()->json($producto, 201);
    }

    public function show(Producto $producto)
    {
        return response()->json($producto);
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $this->authorize('update', $producto);
        $producto->update($request->validated());
        return response()->json($producto);
    }

    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);
        $producto->delete();
        return response()->noContent();
    }
}