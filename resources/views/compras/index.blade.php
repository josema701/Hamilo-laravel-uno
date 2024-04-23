@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Compras</h4>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ url('/compras/registrar') }}" class="btn btn-primary btn-sm">Nueva compra</a>
            </div>
            <div class="col-md-12 ">

                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Item</th>
                                    <th>Proveedor</th>
                                    <th>Contacto</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($compras as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->proveedores->nombre . ' ' . $item->proveedores->apellido }}</td>
                                        <td>{{ $item->proveedores->contacto }}</td>
                                        <td>{{ $item->total }}</td>
                                        <td>
                                            @if ($item->estado == true)
                                                <span class="badge bg-success">Activo</span>
                                            @else
                                                <span class="badge bg-danger">Inactivo</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->usuario->name }}
                                        </td>
                                        <td>
                                            {{-- editar --}}
                                            <a href="{{ url('/clientes/actualizar/' . $item->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            @if ($item->estado == true)
                                                <a href="{{ url('/clientes/estado/' . $item->id) }}"
                                                    class="btn btn-sm btn-danger">Inhab</a>
                                            @else
                                                <a href="{{ url('/clientes/estado/' . $item->id) }}"
                                                    class="btn btn-sm btn-primary">Hab</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $compras->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
