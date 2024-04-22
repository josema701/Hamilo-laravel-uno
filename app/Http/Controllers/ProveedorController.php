<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $item = Proveedor::with('usuario')->paginate(5);
        return view('proveedores.index', compact('item'));
    }
    public function create()
    {
        return view('proveedores.create');
    }
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
        $item->usuario_id = auth()->user()->id;
        if ($item->save()) {
            return redirect('/proveedores')->with('success', 'Registro Agregado correctamente');
        } else {
            return redirect()->back()->with('error', 'El registro no fue realizado');
        }
    }
    public function eliminar(string $id)
    {
        $item = Proveedor::find($id);
        if ($item->delete()) {
            return redirect('/proveedores')->with('success', 'Registro eliminado correctamente');
        } else {
            return redirect()->back()->with('error', 'El registro no fue eliminado');
        }
    }
}
