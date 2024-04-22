@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>
                    Proveedores
                </h4>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ url('/proveedores/registrar') }}" class="btn btn-primary">Nuevo proveedor</a>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success">{{ Session::get('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Item</th>
                                        <th>Nombres y Apellidos</th>
                                        <th>Contacto</th>
                                        <th>Identificacion</th>
                                        <th>Estado</th>
                                        <th>Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item as $row)
                                        <tr>
                                            <td>{{ $row->id }}</td>
                                            <td>{{ $row->nombre . ' ' . $row->apellido }}</td>
                                            <td>{{ $row->contacto }}</td>
                                            <td>{{ $row->identificacion }}</td>
                                            <td>
                                                @if ($row->estado)
                                                <span class="badge bg-success">Activo</span>@else<span
                                                        class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>{{ $row->usuario->name }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <form action="{{ url('/proveedores/' . $row->id)}}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm">🚫</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $item->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
