<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Productos;
use App\Models\Ventas;
use App\Models\VentasDetalle;
use App\Models\VentasDetalleTemporal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentasDetalleTemporalController extends Controller
{
    public function create()
    {
        $productos = Productos::where('estado', true)->where('cantidad', '!=', 0)->paginate(5);
        $carritos = VentasDetalleTemporal::where('usuario_id', auth()->user()->id)->with('productos')->paginate(5);
        $cliente = Cliente::where('estado', true)->get();
        $respuesta = VentasDetalleTemporal::selectRaw('SUM(total) as total')->where('usuario_id', auth()->user()->id)->first();
        $total = $respuesta->total;
        return view('ventas.nuevaVenta', compact('productos', 'carritos', 'cliente', 'total'));
    }
    public function carrito(string $id)
    {
        $data = VentasDetalleTemporal::where('producto_id', $id)->where('usuario_id', auth()->user()->id)->first();
        if ($data != null) {
            return back()->with('error', 'El producto ya se encuentra agregado en la tabla carrito.');
        }
        $producto = Productos::find($id);
        $item = new VentasDetalleTemporal();
        $item->producto_id = $id;
        $item->usuario_id = auth()->user()->id;
        $item->cantidad = 1;
        $item->precio_unitario = $producto->precio_venta;
        $item->total = $producto->precio_venta;
        $item->save();
        return back()->with('success', 'Producto agregado correctamente.');
    }
    public function addCantidad(string $id)
    {
        $item = VentasDetalleTemporal::find($id);
        $producto = Productos::find($item->producto_id);
        if ($item->cantidad < $producto->cantidad) {
            $nuevaCantidad = $item->cantidad + 1;
            $nuevoTotal = round($nuevaCantidad * $item->precio_unitario, 2);
            $item->cantidad = $nuevaCantidad;
            $item->total = $nuevoTotal;
            if ($item->save()) {
                return back();
            } else {
                return back()->with('error', 'Error al modificar.');
            }
        } else {
            return back()->with('error', 'La cantidad solicitada es mayor a la cantidad en STOCK.');
        }
    }
    public function restarCantidad(string $id)
    {
        $item = VentasDetalleTemporal::find($id);
        if ($item->cantidad > 1) {
            $nuevaCantidad = $item->cantidad - 1;
            $nuevoTotal = round($nuevaCantidad * $item->precio_unitario, 2);
            $item->cantidad = $nuevaCantidad;
            $item->total = $nuevoTotal;
            if ($item->save()) {
                return back();
            } else {
                return back()->with('error', 'Error al modificar.');
            }
        } else {
            return back()->with('error', 'La cantidad solicitada no puede ser menor a 1.');
        }
    }
    public function removeCarrito(string $id)
    {
        $item = VentasDetalleTemporal::find($id);
        if($item->delete()){
            return back()->with('success', 'Producto eliminado correctamente.');
        }else{
            return back()->with('error', 'Error al eliminar.');
        }
    }
    public function terminarVenta(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required'
        ]);
        $resultado = VentasDetalleTemporal::selectRaw('SUM(total) as suma')->where('usuario_id', auth()->user()->id)->first();
        $total = $resultado->suma;
        $carritos = VentasDetalleTemporal::where('usuario_id', auth()->user()->id)->get();
        if ($resultado->suma == null) {
            return back()->with('error', 'Necesita agregar productos al carrito.');
        }
        try {
            DB::beginTransaction();
            $item = new Ventas();
            $item->total = $total;
            $item->usuario_id = auth()->user()->id;
            $item->cliente_id = $request->cliente_id;
            $item->save();
            foreach ($carritos as $row) {
                $item2 = new VentasDetalle();
                $item2->venta_id = $item->id;
                $item2->producto_id = $row->producto_id;
                $item2->cantidad = $row->cantidad;
                $item2->precio_unitario = $row->precio_unitario;
                $item2->total = $row->total;
                $item2->save();
                //Restamos la nueva cantidad de un producto
                $item3 = Productos::find($row->producto_id);
                $nueva_cantidad = $item3->cantidad - $row->cantidad;
                $item3->cantidad = $nueva_cantidad;
                $item3->save();
            }
            //Eliminamos todos los registros del usuario logueado
            VentasDetalleTemporal::where('usuario_id', auth()->user()->id)->delete();
            //realizamos las consultas a la base de datos
            DB::commit();
            //guarda todos los cambios en la base de datos
            return redirect('/ventas')->with('success', 'La venta ha sido realizada exitosamente, Gracias.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $th);
        }
    }
}
