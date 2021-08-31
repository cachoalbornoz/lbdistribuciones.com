@extends('base.base')

@section('title', 'Detalle Compras')

@section('breadcrumb')
    {!! Breadcrumbs::render('compra.detalle', $compra) !!}
@stop

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <h5>
                        Compra
                    </h5>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6 text-right">

                    @if ($compra->presupuesto)
                        <a href="{{ route('detallepedidop.show', $compra->presupuesto) }}">
                            Ver presupuesto original
                        </a>
                    @else
                        @if ($compra->presupuesto)
                            <a href="{{ route('detallepresupuesto.show', $compra->presupuesto) }}">
                                Ver presupuesto original
                            </a>
                        @else
                            Compra directa
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
                                    <b> {{ $compra->Proveedor->nombreempresa . ' ' . $compra->Proveedor->nombreCompleto() }}
                                    </b>
                                </td>
                                <td style="width: 15%">
                                    Fecha
                                </td>
                                <td>
                                    <b> {{ date('d-m-Y', strtotime($compra->fecha)) }} </b>
                                </td>
                            </tr>
                            <tr>
                                <td>Observaciones</td>
                                <td><b> {{ $compra->observaciones }} </b></td>
                                <td>Comprobante</td>
                                <td><b>{{ $compra->Comprobante }}</b></td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12 text-right">
                    <a href="{{ route('print.comprobanteprov', [$compra->id, $compra->tipocomprobante]) }}"
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
                    Detalle de la compra
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

                            @foreach ($detallecompra as $detalle)

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
                                    <p>TOTAL $</p>
                                </td>
                                <td class=" text-right">
                                    <p id="suma"> {{ number_format($detallecompra->sum('subtotal'), 2) }} </h5>
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
