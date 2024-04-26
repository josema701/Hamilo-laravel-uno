<?php

namespace App\Http\Controllers\Api;

use App\Models\Productos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductosController extends Controller
{

    public function index()
    {
        $productos = Productos::with('usuario')->paginate(5);
        return response()->json(['mensaje' => 'Registros cargados','datos' => $productos], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'codigo' => 'required|unique:productos',
            'nombre' => 'required',
            'precio_venta' => 'required',
            'precio_compra' => 'required',
            'descripcion' => 'nullable|string|max:100'
        ]);

        // dd(auth()->user());
        $item = new Productos();
        $item->codigo = $request->codigo;
        $item->nombre = $request->nombre;
        $item->precio_venta = $request->precio_venta;
        $item->precio_compra = $request->precio_compra;
        $item->descripcion = $request->descripcion;
        $item->estado = true;
        $item->usuario_id = auth()->user()->id;
        if ($item->save()) {
            return response()->json(["mensaje" => "Registros agregado correctamente", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "El registro no fue realizado"], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Productos::where('id', $id)->first();
        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'codigo' => 'required|unique:productos,codigo,'.$id,
            'nombre' => 'required',
            'precio_venta' => 'required',
            'precio_compra' => 'required',
            'descripcion' => 'nullable|string|max:100'
        ]);

        $item = Productos::find($id);
        $item->codigo = $request->codigo;
        $item->nombre = $request->nombre;
        $item->precio_venta = $request->precio_venta;
        $item->precio_compra = $request->precio_compra;
        $item->descripcion = $request->descripcion;
        $item->estado = true;
        $item->usuario_id = auth()->user()->id;
        if ($item->save()) {
            return response()->json(["mensaje" => "Registros actualizado correctamente", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "El registro no fue actualizado"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Productos::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado actualizado correctamente", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "El estado no fue actualizado"], 500);
        }
    }

    public function listarActivos()
    {
        $item = Productos::where('estado', true)
                        ->orderBy('id', 'desc')
                        ->get();
        return response()->json(["datos" => $item], 200);
    }
}
