<?php

namespace App\Http\Controllers\Api;

use App\Models\Ventas;
use App\Models\Cliente;
use App\Models\Compras;
use App\Models\Productos;
use Illuminate\Http\Request;
use App\Models\VentasDetalle;
use App\Models\ComprasDetalle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(){


        // $compras = Compras::where('estado', true)->count();
        // $ventas = Ventas::where('estado', true)->count();


        $totalVentas = Ventas::where('estado', true)
                                ->where('usuario_id', auth()->user()->id)
                                ->sum('total');
        $totalCompras = Compras::where('estado', true)
                                ->where('usuario_id', auth()->user()->id)
                                ->sum('total');
        $productos = Productos::where('estado', true)
                                ->where('usuario_id', auth()->user()->id)
                                ->count();
        $clientes = Cliente::where('estado', true)
                                ->where('usuario_id', auth()->user()->id)
                                ->count();
        // total_ventas
        // nombre_producto
        $ventasChart = VentasDetalle::select('productos.nombre as nombre_producto', DB::raw('SUM(ventas_detalles.total) as total_ventas'))
                                    ->join('productos', 'ventas_detalles.producto_id', 'productos.id')
                                    ->join('ventas', 'ventas_detalles.venta_id', 'ventas.id')
                                    ->where('ventas.estado', true)
                                    ->where('ventas.usuario_id', auth()->user()->id)
                                    ->groupBy('productos.nombre')
                                    ->get();

        $comprasChart = ComprasDetalle::select('productos.nombre as nombre_producto', DB::raw('SUM(compras_detalles.total) as total_compras'))
                                    ->join('productos', 'compras_detalles.producto_id', 'productos.id')
                                    ->join('compras', 'compras_detalles.compra_id', 'compras.id')
                                    ->where('compras.estado', true)
                                    ->where('compras.usuario_id', auth()->user()->id)
                                    ->groupBy('productos.nombre')
                                    ->get();

        return response()->json([
            'total_ventas' => number_format($totalVentas ,2),
            'total_compras' => number_format($totalCompras ,2),
            'total_productos' => $productos,
            'total_clientes' => $clientes,
            'chartVentas' => $ventasChart,
            'chartCompras' => $comprasChart
        ]);
    }
}
