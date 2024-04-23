@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h4>Clientes</h4>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ url('/clientes/registrar') }}" class="btn btn-primary btn-sm">Nuevo cliente</a>
        </div>
        <div class="col-md-12 ">

            @if(Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Identificacion</th>
                                <th>Estado</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientes as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>{{ $item->apellido }}</td>
                                    <td>{{ $item->identificacion }}</td>
                                    <td>
                                        @if($item->estado == true)
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
                                        <a href="{{ url('/clientes/actualizar/' . $item->id ) }}" class="btn btn-sm btn-warning">Edit</a>
                                        @if($item->estado == true)
                                            <a href="{{ url('/clientes/estado/' . $item->id ) }}" class="btn btn-sm btn-danger">Inhab</a>
                                        @else
                                            <a href="{{ url('/clientes/estado/' . $item->id ) }}" class="btn btn-sm btn-primary">Hab</a>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    {{ $clientes->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
