@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Productos</h4>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm">Nuevo producto</a>
            </div>
            <div class="col-md-12 ">

                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Precio compra</th>
                                        <th>Precio venta</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Usuario</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->codigo }}</td>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->precio_compra }}</td>
                                            <td>{{ $item->precio_venta }}</td>
                                            <td>{{ $item->descripcion }}</td>
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
                                                <a href="{{ url('/productos/actualizar/' . $item->id) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>
                                                @if ($item->estado == true)
                                                    <a href="{{ url('/productos/estado/' . $item->id) }}"
                                                        class="btn btn-sm btn-danger">Inhab</a>
                                                @else
                                                    <a href="{{ url('/productos/estado/' . $item->id) }}"
                                                        class="btn btn-sm btn-primary">Hab</a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>


                            {{ $productos->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
