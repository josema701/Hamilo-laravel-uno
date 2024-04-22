@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Actualizar Productos</h4>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ url('/productos') }}" class="btn btn-primary btn-sm">Volver al listado</a>
            </div>
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ url('/productos/actualizar/' . $producto->id) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="codigo">Codigo</label>
                                        <input type="text" name="codigo" class="form-control" value="{{ $producto->codigo }}">
                                        @error('codigo') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre producto</label>
                                        <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}">
                                        @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_venta">Precio venta</label>
                                        <input type="number" name="precio_venta" class="form-control" value="{{ $producto->precio_venta }}">
                                        @error('precio_venta') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_compra">Precio compra</label>
                                        <input type="number" name="precio_compra" class="form-control" value="{{ $producto->precio_compra }}">
                                        @error('precio_compra') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <textarea name="descripcion" cols="30" rows="2" class="form-control">{{ $producto->descripcion }}</textarea>
                                        @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
