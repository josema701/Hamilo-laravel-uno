<?php

namespace App\Http\Controllers\Api;

use App\Models\Ventas;
use App\Models\Productos;
use Illuminate\Http\Request;
use App\Models\VentasDetalle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventas = Ventas::with('usuario')->with('clientes')->orderBy('id', 'desc')->paginate(5);
        return response()->json(['mensaje' => 'Registros cargados','datos' => $ventas], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
            'total' => 'required',
            'detalle' => 'required',
            'detalle.*.producto_id' => 'required',
            'detalle.*.cantidad' => 'required',
            'detalle.*.precio_unitario' => 'required',
            'detalle.*.precio_total' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $item = new Ventas();
            $item->total = $request->total;
            $item->usuario_id = auth()->user()->id;
            $item->cliente_id = $request->cliente_id;
            $item->save();

            foreach ($request->detalle as $detalle){
                $item2 = new VentasDetalle();
                $item2->venta_id = $item->id;
                $item2->producto_id = $detalle['producto_id'];
                $item2->cantidad = round($detalle['cantidad'] ,2);
                $item2->precio_unitario = round($detalle['precio_unitario'] ,2);
                $item2->total = round($detalle['precio_total'] ,2);
                $item2->save();

                $item3 = Productos::find($item2->producto_id);
                $nueva_cantidad = $item3->cantidad - $item2->cantidad;
                $item3->cantidad = $nueva_cantidad;
                $item3->save();
            }
            DB::commit();
            return response()->json(["mensaje" => "Registros agregado correctamente", "datos" => $item], 200);
        } catch(\Throwable $th) {
            DB::rollBack();
            dd($th);
            return response()->json(['mensaje' => 'El registro no fue realizado'], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Ventas::where('id', $id)
                        ->with('clientes', 'usuario', 'detalles', 'detalles.productos')
                        ->first();

        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    public function destroy(string $id)
    {
        $item = Ventas::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado actualizado correctamente", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "El estado no fue actualizado"], 500);
        }
    }
}
