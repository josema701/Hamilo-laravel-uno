<?php

namespace App\Http\Controllers;

use App\Models\Compras;
use App\Models\ComprasDetalle;
use App\Models\ComprasDetalleTemporal;
use App\Models\Productos;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComprasDetalleTemporalController extends Controller
{
    public function create()
    {
        $productos = Productos::where('estado', true)->paginate(5, ['*'], 'product');
        $carritos = ComprasDetalleTemporal::where('usuario_id', auth()->user()->id)->with('productos')->orderBy('id', 'desc')->paginate(5, ['*'], 'carr');
        $resultado = ComprasDetalleTemporal::selectRaw('SUM(total) as suma')->where('usuario_id', auth()->user()->id)->first();
        $total = $resultado->suma;
        $proveedor = Proveedor::where('estado', true)->get();
        return view('compras.nuevaCompra', compact('productos', 'carritos', 'total', 'proveedor'));
    }
    public function carrito(string $id)
    {
        $validacion = ComprasDetalleTemporal::where('producto_id', $id)->where('usuario_id', auth()->user()->id)->first();
        if ($validacion == null) {
            $producto = Productos::find($id);
            $item = new ComprasDetalleTemporal();
            $item->producto_id = $id;
            $item->usuario_id = auth()->user()->id;
            $item->cantidad = 1;
            $item->precio_unitario = $producto->precio_compra;
            $item->total = $producto->precio_compra;
            if ($item->save()) {
                return back()->with('success', 'El producto fue agregado correctamente.');
            } else {
                return back()->with('error', 'Error al agregar el producto.');
            }
        } else {
            return back()->with('error', 'El producto ya se encuentra registrado den la lista carrito.');
        }
    }
    public function removeCarrito(string $id)
    {
        $item = ComprasDetalleTemporal::find($id);
        if ($item->delete()) {
            return back()->with('success', 'El producto fue elimnado correctamente.');
        } else {
            return back()->with('error', 'Error al eliminar el producto.');
        }
    }
    public function addCantidad(string $id)
    {
        $item = ComprasDetalleTemporal::find($id);
        $nuevaCantidad = $item->cantidad + 1;
        $nuevoTotal = round($nuevaCantidad * $item->precio_unitario, 2);
        $item->cantidad = $nuevaCantidad;
        $item->total = $nuevoTotal;
        $item->save();
        return back();
    }
    public function restarCantidad(string $id)
    {
        $item = ComprasDetalleTemporal::find($id);
        if ($item->cantidad <= 1) {
            return back()->with('error', 'La cantidad no puede disminuir de 1.');
        }
        $nuevaCantidad = $item->cantidad - 1;
        $nuevoTotal = round($nuevaCantidad * $item->precio_unitario, 2);
        $item->cantidad = $nuevaCantidad;
        $item->total = $nuevoTotal;
        $item->save();
        return back();
    }
    public function terminarCompra(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required'
        ]);
        $resultado = ComprasDetalleTemporal::selectRaw('SUM(total) as suma')->where('usuario_id', auth()->user()->id)->first();
        $total = $resultado->suma;
        $carritos = ComprasDetalleTemporal::where('usuario_id', auth()->user()->id)->get();
        if ($resultado->suma == null) {
            return back()->with('error', 'Necesita agregar productos al carrito.');
        }
        try {
            DB::beginTransaction();
            $item = new Compras();
            $item->total = $total;
            $item->usuario_id = auth()->user()->id;
            $item->proveedor_id = $request->proveedor_id;
            $item->save();
            foreach ($carritos as $row) {
                $item2 = new ComprasDetalle();
                $item2->compra_id = $item->id;
                $item2->producto_id = $row->producto_id;
                $item2->cantidad = $row->cantidad;
                $item2->precio_unitario = $row->precio_unitario;
                $item2->total = $row->total;
                $item2->save();
                //Sumamos la nueva cantidad de un producto
                $item3 = Productos::find($row->producto_id);
                $nueva_cantidad = $item3->cantidad + $row->cantidad;
                $item3->cantidad = $nueva_cantidad;
                $item3->save();
            }
            //Eliminamos todos los registros del usuario logueado
            ComprasDetalleTemporal::where('usuario_id', auth()->user()->id)->delete();
            //realizamos las consultas a la base de datos
            DB::commit();
            //guarda todos los cambios en la base de datos
            return redirect('/compras')->with('success', 'La compra ha sido realizada exitosamente, Gracias.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $th);
        }
    }
}
