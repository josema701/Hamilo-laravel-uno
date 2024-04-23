<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::with('usuario')->orderBy('id', 'desc')->paginate(5);

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
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
            return redirect('/clientes')->with('success', 'Registro Agregado correctamente');
        } else {
            return redirect()->back()->with('error', 'El registro no fue realizado');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cliente = Cliente::find($id);
        return view('clientes.edit', compact('cliente'));
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
            return redirect('/clientes')->with('success', 'Registro modificado correctamente');
        } else {
            return redirect()->back()->with('error', 'El registro no fue realizado');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function cambiarEstado($id){
        $item = Cliente::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return back()->with('success', 'Registro Actualizado correctamente');
        } else {
            return back()->with('error', 'El registro no fue actualizado');
        }
    }
}
