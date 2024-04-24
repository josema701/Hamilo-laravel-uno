@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">🛸 Detalle compras</h4>
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
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($detalles as $item)
                                        <tr>
                                            <td>{{ $item->productos->nombre }}</td>
                                            <td>{{ $item->productos->codigo }}</td>
                                            <td>{{ $item->cantidad }}</td>
                                            <td>{{ $item->precio_unitario }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ url('/compras') }}" class="btn btn-danger">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
