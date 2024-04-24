@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
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
                                        <th>Precio <small class="text-danger">(venta)</small></th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $item)
                                        <tr>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->codigo }}</td>
                                            <td>{{ $item->cantidad }}</td>
                                            <td>{{ $item->precio_venta }}</td>
                                            <td>
                                                <a href="{{ url('/ventas/add-carrito/' . $item->id) }}"
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
                    <form action="{{ url('/ventas/guardar') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <label for="cliente_id">Cliente</label>
                                    <select name="cliente_id" id="cliente_id" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        @foreach ($cliente as $item)
                                            <option value="{{ $item->id }}">{{ $item->nombre . ' ' . $item->apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cliente_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                    <div class="valid-feedback">
                                        Bien!
                                    </div>
                                    <div class="invalid-feedback">
                                        Llene este campo.
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-5">
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
                                    <tbody>
                                        @foreach ($carritos as $item)
                                            <tr>
                                                <td>{{ $item->productos->nombre }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ url('/ventas/decrementar-carrito/' . $item->id) }}"
                                                            class="btn btn-danger btn-sm">➖</a>
                                                        <button type="button"
                                                            class="btn btn-outline-primary btn-sm">{{ $item->cantidad }}</button>
                                                        <a href="{{ url('/ventas/incrementar-carrito/' . $item->id) }}"
                                                            class="btn btn-success btn-sm">➕</a>
                                                    </div>
                                                </td>
                                                <td>{{ $item->precio_unitario }}</td>
                                                <td>{{ $item->total }}</td>
                                                <td>
                                                    <a href="{{ url('/ventas/remove-carrito/' . $item->id) }}"
                                                        class="btn btn-sm btn-danger">🚫</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-center">TOTAL</th>
                                            <th class="bg-dark text-white">{{ $total }}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                {{ $carritos->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ url('/compras') }}" class="btn btn-danger">Volver</a>
                            <button type="submit" class="btn btn-warning">Terminar Venta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
