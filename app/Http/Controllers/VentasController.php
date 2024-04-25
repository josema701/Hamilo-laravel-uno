<?php

namespace App\Http\Controllers;

use App\Models\Ventas;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function index()
    {
        $ventas = Ventas::with('usuario')->with('clientes')->orderBy('id', 'desc')->paginate(5);
        return view('ventas.index', compact('ventas'));
    }

    public function show($id){
        $venta = Ventas::where('id', $id)
                        ->with('clientes', 'usuario', 'detalles', 'detalles.productos')
                        ->first();

        return view('ventas.detalle', compact('venta'));
    }

    public function estado($id){
        $venta = Ventas::find($id);
        $venta->estado = !$venta->estado;
        if ($venta->save()) {
            return back()->with('success', 'Estado de la venta actualizado!');
        } else {
            return back()->with('error', 'No se pudo actualizar el estado!');
        }
    }
}
