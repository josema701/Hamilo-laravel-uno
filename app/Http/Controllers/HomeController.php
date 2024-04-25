<?php

namespace App\Http\Controllers;


use App\Models\Ventas;
use App\Models\Cliente;
use App\Models\Compras;
use App\Models\Productos;
use Illuminate\Http\Request;
use App\Models\VentasDetalle;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $productos = Productos::where('estado', true)->count();
        $clientes = Cliente::where('estado', true)->count();
        $compras = Compras::where('estado', true)->count();
        $ventas = Ventas::where('estado', true)->count();

        $totalCompras = Compras::where('estado', true)->sum('total');
        $totalVentas = Ventas::where('estado', true)->sum('total');

        // ventas agrupadas por mes
        $ventasMes = Ventas::select(DB::raw('MONTH(created_at) as mes'), DB::raw('SUM(total) as total'))
                            ->whereYear('created_at', date('Y'))
                            ->groupBy(DB::raw('MONTH(created_at)'))
                            ->get();
        // dd($ventasMes);

        // arary mes y total
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $totales = [];

        foreach ($meses as $index => $mes){
            $totales[$index] = 0;
            foreach ($ventasMes as $venta){
                if($venta->mes == ($index+1)){
                    $totales[$index] = $venta->total;
                }
            }
        }

        // dd($meses);

        $masVendidos = VentasDetalle::select(DB::raw('SUM(ventas_detalles.cantidad) as cantidad'), 'productos.nombre')
                                ->join('productos', 'productos.id', 'ventas_detalles.producto_id')
                                ->whereYear('ventas_detalles.created_at', date('Y'))
                                ->groupBy('ventas_detalles.producto_id')
                                ->orderBy('cantidad', 'DESC')
                                ->take(10)
                                ->get();
        // dd($masVendidos);



        return view('home', compact('productos', 'clientes', 'compras', 'ventas'
                                    , 'totalCompras', 'totalVentas', 'meses', 'totales', 'masVendidos'));
    }
}
