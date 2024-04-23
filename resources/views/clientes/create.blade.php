@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h4 class="card-title">Nuevo registro</h4>
                    </div>
                    <form action="{{ url('/clientes')}}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre"
                                            placeholder="" required>
                                        <div class="valid-feedback">
                                            Bien!
                                        </div>
                                        <div class="invalid-feedback">
                                            Llene este campo.
                                          </div>
                                        @error('nombre')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="apellido">Apellido</label>
                                        <input type="text" class="form-control" name="apellido" id="apellido"
                                            placeholder="">
                                            <div class="valid-feedback">
                                                Bien!
                                            </div>
                                            <div class="invalid-feedback">
                                                Llene este campo.
                                              </div>
                                        @error('apellido')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <label for="identificacion">Identificacion</label>
                                        <input type="text" class="form-control" name="identificacion" id="identificacion"
                                            placeholder="">
                                            <div class="valid-feedback">
                                                Bien!
                                            </div>
                                            <div class="invalid-feedback">
                                                Llene este campo.
                                              </div>
                                        @error('identificacion')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ url('/clientes') }}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
