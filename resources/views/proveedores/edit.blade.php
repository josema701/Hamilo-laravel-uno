@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h4 class="card-title">Actualizar Registro</h4>
                    </div>
                    <form action="{{ url('/proveedores/actualizar/' . $proveedor->id )}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            @if (Session::has('error'))
                                <div class="alert alert-danger">{{ Session::get('error') }}</div>
                            @endif
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" value="{{ $proveedor->nombre }}" placeholder="Escriba.." required>
                                        @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <input type="text" class="form-control" name="apellido" value="{{ $proveedor->apellido }}" placeholder="Escriba..">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="identificacion">Identificacion</label>
                                        <input type="text" class="form-control" name="identificacion" value="{{ $proveedor->identificacion }}" placeholder="Escriba.." required>
                                        @error('identificacion') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="contacto">Contacto</label>
                                        <input type="text" class="form-control" name="contacto" value="{{ $proveedor->contacto }}" placeholder="Escriba.." required>
                                        @error('contacto') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ url('/proveedores')}}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
