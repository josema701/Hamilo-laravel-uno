@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>Detalle de venta</h4>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ url('/ventas') }}" class="btn btn-primary btn-sm">Volver al listado</a>
            </div>
            <div class="col-md-12 ">
                @if (Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <p><b>Cliente: </b> {{ $venta->clientes->nombre .' '. $venta->clientes->apellido }}</p>
                        <p><b>Total:</b> {{ $venta->total }}</p>
                        <p><b>Fecha:</b> {{ $venta->created_at }}</p>
                        <p><b>Usuario:</b> {{ $venta->usuario->name }}</p>

                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Item</th>
                                    <th>Cantidad</th>
                                    <th>Precio unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($venta->detalles as $item)
                                    <tr>
                                        <td>
                                            {{ $item->productos->nombre }} <br>
                                            <small class="text-muted">{{ $item->productos->codigo }}</small>
                                        </td>
                                        <td>{{ $item->cantidad }}</td>
                                        <td>{{ $item->precio_unitario }}</td>
                                        <td>{{ $item->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"><b>Total</b></td>
                                    <td>{{ $venta->total }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
