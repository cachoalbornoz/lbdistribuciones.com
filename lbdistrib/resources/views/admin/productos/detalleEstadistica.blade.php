@extends('base.base')

@section('title', 'Estadistica del producto')

@section('breadcrumb')
    {!! Breadcrumbs::render('venta') !!}
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('/css/jquery.fancybox.min.css') }}">
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i>
                    Estadisticas de venta del producto
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center small" style="font-size: smaller">
                            <thead class=" bg-secondary text-white">
                                <tr>
                                    <td style=" width: 100px">Código</td>
                                    <td style=" width: 200px">Foto</td>
                                    <td style="text-align: left;">Nombre producto</td>
                                    <td style=" width: 100px">Cant ventas</td>
                                    <td style=" width: 100px">$ Lista</td>
                                    <td style=" width: 100px">$ Venta</td>
                                    <td style=" width: 100px">$ Promedio</td>
                                    <td style=" width: 200px">Marca</td>
                                </tr>
                            </thead>
                            <tr>
                                <td> {{ $producto->codigobarra }} </td>
                                <td>
                                    @if (isset($producto->image) and is_file('images/upload/productos/' . $producto->image))
                                        <a href="{{ asset('images/upload/productos/' . $producto->image) }}"
                                            data-fancybox="gallery"
                                            data-caption="&lt;b&gt;{{ $producto->nombre }}&lt;/b&gt;&lt;br /&gt;Precio Venta $ {{ $producto->precioventa }} ">
                                            <img src="{{ asset('images/upload/productos/' . $producto->image) }}"
                                                class="img-rounded" height="75px" width="75px">
                                        </a>
                                    @else
                                        <img src="{{ asset('images/frontend/imagen-no-disponible.png') }}"
                                            class="img-rounded" height="75px" width="75px">
                                    @endif
                                </td>
                                <td style="text-align: left;">
                                    <a href="{{ route('producto.edit', $producto->id) }}">
                                        {{ $producto->nombre }}
                                    </a>
                                </td>
                                <td> {{ $cantidad }}</td>
                                <td> {{ number_format($producto->preciolista, 2, ',', '.') }}</td>
                                <td> {{ number_format($producto->precioventa, 2, ',', '.') }}</td>
                                <td> {{ number_format($promedio, 2, ',', '.') }}</td>
                                <td>@if (isset($producto->Marca->nombre)){{ $producto->Marca->nombre }}@endif </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <h5>Detalle de las ventas</h5>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6">

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover small text-center" style="font-size: smaller"
                            id="detalleestadisticas">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <td style=" width: 100px">Nro</td>
                                    <td style=" width: 200px">Fecha</td>
                                    <td style="text-align: left;">Razón social</td>
                                    <td style=" width: 200px">Precio venta</td>
                                    <td style=" width: 200px">Cantidad</td>
                                    <td style=" width: 200px">Descuento </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventas as $venta)
                                    @foreach ($venta->detalleventas as $detalle)
                                        @if ($producto->id == $detalle->producto)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('detalleventa.show', $venta->id) }}">
                                                        {{ $venta->nro }}
                                                    </a>
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($venta->fecha)) }}</td>
                                                <td style="text-align: left;">
                                                    @if (isset($venta->Contacto->nombreempresa))
                                                        {{ $venta->Contacto->nombreempresa }}
                                                    @else
                                                        Info no disponible
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $detalle->precio }}
                                                </td>
                                                <td>
                                                    {{ $detalle->cantidad }}
                                                </td>
                                                <td>
                                                    {{ $detalle->descuento * 100 }} %
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>


@endsection

@section('js')

    <script src="{{ asset('/js/jquery.fancybox.min.js') }}"> </script>

    <script>
        $(function() {
            crearDataTable('detalleestadisticas', 1, 1);
        });
    </script>

@stop
