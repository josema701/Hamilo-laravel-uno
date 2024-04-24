@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Ventas</h4>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ url('/ventas/registrar') }}" class="btn btn-primary btn-sm">Nueva venta</a>
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
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventas as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->clientes->nombre . ' ' . $item->clientes->apellido }}</td>
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
                                            <a href="#"
                                                class="btn btn-sm btn-warning">Detalle</a>
                                            @if ($item->estado == true)
                                                <a href="#"
                                                    class="btn btn-sm btn-danger">Inhab</a>
                                            @else
                                                <a href="#"
                                                    class="btn btn-sm btn-primary">Hab</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $ventas->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
