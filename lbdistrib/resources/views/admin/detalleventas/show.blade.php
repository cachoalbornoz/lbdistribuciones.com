@extends('base.base')

@section('title', 'Detalle Ventas')

@section('breadcrumb')
    {!! Breadcrumbs::render('venta.detalle', $venta) !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <h5>
                        Venta
                    </h5>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 text-right">

                    @if ($venta->pedido)
                        <a href="{{ route('detallepedido.show', $venta->pedido) }}">
                            Ver pedido original
                        </a>
                    @else
                        @if ($venta->presupuesto)
                            <a href="{{ route('detallepresupuesto.show', $venta->presupuesto) }}">
                                Ver presupuesto original
                            </a>
                        @else
                            Venta directa
                        @endif
                    @endif

                </div>
            </div>
        </div>

        <div class="card-body border border-primary">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">

                    <div class="table-responsive">
                        <table class="table small table-borderless" style="font-size: smaller">
                            <tr>
                                <td style="width: 15%">Razón social</td>
                                <td>
                                    <b> {{ $venta->Contacto->nombreempresa . ' ' . $venta->Contacto->nombreCompleto() }}
                                    </b>
                                </td>
                                <td style="width: 15%">
                                    Fecha
                                </td>
                                <td>
                                    <b> {{ date('d-m-Y', strtotime($venta->fecha)) }} </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Vendedor</td>
                                <td><b>{{ $venta->Vendedor->nombrecompleto() }}</b></td>
                                <td>Total</td>
                                <td><b> $ {{ $venta->total }} </b></td>
                            </tr>
                            <tr>
                                <td>Observaciones</td>
                                <td><b> {{ $venta->observaciones }} </b></td>
                                <td>{{ $venta->Tipocomprobante->comprobante }}</td>
                                <td><b>{{ $venta->nro }}</td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 text-right">
                    <a href="{{ route('print.comprobante', [$venta->id, $venta->tipocomprobante]) }}"
                        class="btn btn-large btn-success">
                        <i class="fa fa-print" aria-hidden="true"> </i> Imprimir
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    Detalle de la venta
                </div>
                <div class="card-body">

                    <table class="table table-hover table-striped table-bordered" id="tablaDetalle"
                        style="font-size: smaller">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Producto</th>
                                <th width="15px">Cantidad</th>
                                <th width="15px">Precio</th>
                                <th width="15px">Descuento</th>
                                <th width="15px">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($detalleventa as $detalle)

                                <tr id="item{{ $detalle->id }}">
                                    <td class=" text-center">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        @if (isset($detalle->Producto->nombre))
                                            {{ $detalle->Producto->nombre }}
                                        @else
                                            Producto removido Cod {{ $detalle->producto }}
                                        @endif
                                    </td>
                                    <td class=" text-center">
                                        {{ $detalle->cantidad }}
                                    </td>
                                    <td class=" text-center">
                                        {{ $detalle->precio }}
                                    </td>
                                    <td class=" text-center">
                                        {{ $detalle->descuento * 100 }} %
                                    </td>
                                    <td class=" text-right">
                                        {{ $detalle->subtotal }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class=" text-center">
                                    <h5>$</h5>
                                </td>
                                <td class=" text-right">
                                    <h4>
                                        <p id="suma"> {{ number_format($detalleventa->sum('subtotal'), 2) }}
                                    </h4>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>


    </script>
@stop
