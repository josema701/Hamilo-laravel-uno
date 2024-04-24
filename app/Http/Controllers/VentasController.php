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
}
