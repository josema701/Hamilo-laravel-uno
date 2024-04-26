<?php

namespace App\Http\Controllers\Api;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with('usuario')->orderBy('id', 'desc')->paginate(20);
        return response()->json(['mensaje' => 'Registros cargados','datos' => $clientes], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required"
        ]);
        $item = new Cliente();
        $item->nombre = $request->nombre;
        $item->apellido = $request->apellido;
        $item->identificacion = $request->identificacion;
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
    public function show(string $id)
    {
        $item = Cliente::where('id', $id)->first();
        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required"
        ]);
        $item = Cliente::find($id);
        $item->nombre = $request->nombre;
        $item->apellido = $request->apellido;
        $item->identificacion = $request->identificacion;
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
        $item = Cliente::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado actualizado correctamente", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "El estado no fue actualizado"], 500);
        }
    }

    public function listarActivos()
    {
        $item = Cliente::where('estado', true)
                        ->orderBy('id', 'desc')
                        ->get();
        return response()->json(["datos" => $item], 200);
    }
}
