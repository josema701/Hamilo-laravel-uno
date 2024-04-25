<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = Proveedor::with('usuario')->paginate(5);
        return response()->json(["mensaje" => "Registros cargados", "datos" => $item], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "nombre" => "required",
            "identificacion" => "required",
            "contacto" => "required"
        ]);
        $item = new Proveedor();
        $item->nombre = $request->nombre;
        $item->contacto = $request->contacto;
        $item->identificacion = $request->identificacion;
        $item->apellido = $request->apellido;
        $item->usuario_id = 1;
        if ($item->save()) {
            return response()->json(["mensaje" => "Registros agregado correctamente", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "El registro no fue realizado"], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Proveedor::find($id);
        return response()->json(["datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            "nombre" => "required",
            "identificacion" => "required",
            "contacto" => "required"
        ]);
        $item = Proveedor::find($id);
        $item->nombre = $request->nombre;
        $item->contacto = $request->contacto;
        $item->identificacion = $request->identificacion;
        $item->apellido = $request->apellido;
        $item->usuario_id = 1;
        if ($item->save()) {
            return response()->json(["mensaje" => "Registros modificados correctamente", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "El registro no fue modificado"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Proveedor::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Registros modificados correctamente", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "El registro no fue modificado"], 500);
        }
    }
    public function listarActivos()
    {
        $item = Proveedor::where('estado', true)
            ->orderBy('id', 'desc')
            ->get();
        return response()->json(["datos" => $item], 200);
    }
}
