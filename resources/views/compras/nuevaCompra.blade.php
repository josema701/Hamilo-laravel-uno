@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">🛸 Productos</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Codigo</th>
                                        <th>Cantidad</th>
                                        <th>Precio <small class="text-danger">(Compra)</small></th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $item)
                                        <tr>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->codigo }}</td>
                                            <td>{{ $item->cantidad }}</td>
                                            <td>{{ $item->precio_compra }}</td>
                                            <td>
                                                <a href="#"
                                                    class="btn btn-sm btn-primary">➕</a>
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
            <div class="col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">🛒 Carrito</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>Precio <small class="text-danger">(Unitario)</small></th>
                                        <th>Subtotal</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
