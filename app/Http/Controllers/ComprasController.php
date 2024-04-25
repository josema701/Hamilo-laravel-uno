<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\ComprasDetalle;
use App\Models\Productos;
use Illuminate\Http\Request;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compras::with('usuario')->with('proveedores')->orderBy('id', 'desc')->paginate(5);
        return view('compras.index', compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detalles = ComprasDetalle::where('compra_id', $id)->with('productos')->get();
        return view('compras.detalle', compact('detalles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compras $compras)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Compras $compras)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compras $compras)
    {
        //
    }
    public function estado(string $id)
    {
        $item = Compras::find($id);
        $item->estado = !$item->estado;
        if($item->save())
        {
            return redirect('/compras')->with('success', 'Estado modificado correctamente.');
        } else {
            return redirect('/compras')->with('error', 'No se puede modificar el estado.');
        }
    }
}
