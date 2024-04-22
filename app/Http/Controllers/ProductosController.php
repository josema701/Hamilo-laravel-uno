<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    // listar productos
    public function index(){
        $productos = Productos::with('usuario')
                                // ->get();
                                ->paginate(5);

        // dd($productos);

        return view('productos.index', compact('productos'));

        // return response()->json(['data' => $productos]);

    }

    // mostrara formulario de registro
    public function create(){
        return view('productos.create');
    }

    // guardar en base de datos
    public function store(Request $request){
        // dd($request->all());

        $this->validate($request, [
            'codigo' => 'required|unique:productos',
            'nombre' => 'required',
            'precio_venta' => 'required',
            'precio_compra' => 'required',
            'descripcion' => 'nullable|string|max:100'
        ]);

        $nuevo = new Productos();
        $nuevo->codigo = $request->codigo;
        $nuevo->nombre = $request->nombre;
        $nuevo->precio_venta = $request->precio_venta;
        $nuevo->precio_compra = $request->precio_compra;
        $nuevo->descripcion = $request->descripcion;
        $nuevo->estado = true;
        $nuevo->usuario_id = auth()->user()->id;
        $nuevo->save();

        return redirect('/productos')->with('success', 'Producto registrado correctamente!');
    }

    // formulario de edicion
    public function edit($id){
        $producto = Productos::where('id', $id)->first();
        // $producto = Productos::find($id);
        return view('productos.edit', compact('producto'));
    }

    // actualizamos la base de datos
    public function update(Request $request, $id){
        // dd($request->all());
        $this->validate($request, [
            'codigo' => 'required|unique:productos,codigo,'.$id,
            'nombre' => 'required',
            'precio_venta' => 'required',
            'precio_compra' => 'required',
            'descripcion' => 'nullable|string|max:100'
        ]);

        $nuevo = Productos::find($id);
        $nuevo->codigo = $request->codigo;
        $nuevo->nombre = $request->nombre;
        $nuevo->precio_venta = $request->precio_venta;
        $nuevo->precio_compra = $request->precio_compra;
        $nuevo->descripcion = $request->descripcion;
        $nuevo->estado = true;
        $nuevo->usuario_id = auth()->user()->id;
        $nuevo->save();

        return redirect('/productos')->with('success', 'Producto actualizado correctamente!');
    }

    // cambiar estado
    public function cambiarEstado($id){
        $producto = Productos::find($id);
        $producto->estado = !$producto->estado;
        $producto->save();

        return redirect('/productos');
    }

}
