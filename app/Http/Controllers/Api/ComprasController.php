<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Models\Compras;
use App\Models\Productos;
use Illuminate\Http\Request;
use App\Models\ComprasDetalle;
use App\Http\Controllers\Controller;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compras::with('usuario')->with('proveedores')->orderBy('id', 'desc')->paginate(5);
        return response()->json(['mensaje' => 'Registros cargados','datos' => $compras], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required',
            'total' => 'required',
            'detalle' => 'required',
            'detalle.*.producto_id' => 'required',
            'detalle.*.cantidad' => 'required',
            'detalle.*.precio_unitario' => 'required',
            'detalle.*.precio_total' => 'required',
        ]);

        try {
            DB::beginTransaction();
            $item = new Compras();
            $item->total = $request->total;
            $item->usuario_id = auth()->user()->id;
            $item->proveedor_id = $request->proveedor_id;
            $item->save();

            foreach ($request->detalle as $detalle){
                $item2 = new ComprasDetalle();
                $item2->compra_id = $item->id;
                $item2->producto_id = $detalle['producto_id'];
                $item2->cantidad = round($detalle['cantidad'] ,2);
                $item2->precio_unitario = round($detalle['precio_unitario'] ,2);
                $item2->total = round($detalle['precio_total'] ,2);
                $item2->save();

                $item3 = Productos::find($item2->producto_id);
                $nueva_cantidad = $item3->cantidad + $item2->cantidad;
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
        $item = Compras::where('id', $id)
                            ->with('proveedores', 'usuario', 'detalles', 'detalles.productos')
                            ->first();

        return response()->json(["mensaje" => "Registro encontrado", "datos" => $item], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Compras::find($id);
        $item->estado = !$item->estado;
        if ($item->save()) {
            return response()->json(["mensaje" => "Estado actualizado correctamente", "datos" => $item], 200);
        } else {
            return response()->json(["mensaje" => "El estado no fue actualizado"], 500);
        }
    }
}
