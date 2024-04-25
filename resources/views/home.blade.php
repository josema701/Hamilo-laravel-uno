@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-3 p-1">
                <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-cubes" style="font-size:4em;"></i>
                            </div>
                            <div class="col-8">
                                <h4>{{ $productos }}</h4>
                                Productos
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-3 p-1">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <i class="fa fa-users" style="font-size:4em;" ></i>
                        </div>
                        <div class="col-8">
                            <h4>5</h4>
                            Proveedores
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

            <div class="col-md-3 p-1">
                <div class="card bg-dark text-white shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-user-plus" style="font-size:4em;"></i>
                            </div>
                            <div class="col-8">
                                <h4>{{ $clientes }}</h4>
                                Clientes
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 p-1">
                <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-shopping-cart" style="font-size:4em;"></i>
                            </div>
                            <div class="col-8">
                                <h4>{{ $compras }}</h4>
                                Compras
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 p-1">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-cart-plus" style="font-size:4em;"></i>
                            </div>
                            <div class="col-8">
                                <h4>{{ $ventas }}</h4>
                                Ventas
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 p-1">
                <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-area-chart" style="font-size:4em;"></i>
                            </div>
                            <div class="col-8">
                                <h4>$ {{ number_format($totalCompras, 2) }}</h4>
                                Total Compras
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 p-1">
                <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-line-chart" style="font-size:4em;"></i>
                            </div>
                            <div class="col-8">
                                <h4>$ {{ number_format($totalVentas, 2) }}</h4>
                                Total Ventas
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 p-1">
                <div class="card bg-danger text-white shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-usd" style="font-size:4em;"></i>
                            </div>
                            <div class="col-8">
                                <h4>$ {{ number_format($totalVentas - $totalCompras, 2) }}</h4>
                                Total Utilidad
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <canvas id="grafico"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <canvas id="grafico2"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        var xValues = [
            @foreach ($meses as $mes)
                "{{ $mes }}",
            @endforeach
        ]
        var yValues = [
            @foreach ($totales as $total)
                {{ $total }},
            @endforeach
        ];
        var barColors = ["red", "green", "blue", "orange", "brown"];

        new Chart("grafico", {
            type: "bar",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: "Ventas mensuales"
                }
            }
        });

        // grafico para productos mas vendidos
        new Chart("grafico2", {
            type: "pie",
            data: {
                labels: [
                    @foreach ($masVendidos as $itemn)
                        "{{ $itemn->nombre }}",
                    @endforeach
                ],
                datasets: [{
                    backgroundColor: ["#b91d47", "#00aba9", "#2b5797", "#e8c3b9", "#1e7145"],
                    data: [
                        @foreach ($masVendidos as $itemc)
                            {{ $itemc->cantidad }},
                        @endforeach
                    ]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "10 Productos mas vendidos"
                }
            }
        });
    </script>
@endsection
