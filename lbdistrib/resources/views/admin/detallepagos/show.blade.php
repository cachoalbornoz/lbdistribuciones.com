@extends('base.base')

@section('title', 'Detalle pago')

@section('breadcrumb')
{!! Breadcrumbs::render('pago.detalle', $pago) !!}
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-lg-10">
                <h5>
                    {{ ucwords(strtolower($pago->Tipocomprobante->comprobante)) }}
                </h5>
            </div>
            <div class="col-xs-12 col-sm-1 col-lg-1 text-center">
                <a href="{{ route('pago.pagoProveedor', [$pago->proveedor]) }}" class="btn btn-secondary">
                    Cerrar
                </a>
            </div>
            <div class="col-xs-12 col-sm-1 col-lg-1 text-center">
                <a href="{{ route('print.comprobanteprov', [$pago->id, $pago->tipocomprobante]) }}" class="btn btn-success">
                    <i class="fa fa-print" aria-hidden="true"> </i>
                </a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <div class="table-responsive">
                    <table class="table small table-borderless" style="font-size: smaller">
                        <tr>
                            <td style="width: 15%">Razón social</td>
                            <td>
                                <b> {{ $pago->Proveedor->nombreempresa . ' ' . $pago->Proveedor->nombreCompleto() }}
                                </b>
                            </td>
                            <td style="width: 15%">
                                Fecha
                            </td>
                            <td>
                                <b> {{ date('d-m-Y', strtotime($pago->fecha)) }} </b>
                            </td>
                        </tr>
                        <tr>
                            <td>Observaciones</td>
                            <td><b> {{ $pago->observaciones }} </b></td>
                            <td>Comprobante Nro</td>
                            <td><b>{{ $pago->nro }}</b></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">

    <div class="card-body">

        <table class="table small table-borderless" style="font-size: smaller">
            <tr>
                <td colspan="3">
                    <h5>Detalle del pago - Efectivo / Transferencias</h5>
                </td>
            </tr>
            <tr class="bg-secondary text-white">
                <td>Concepto</td>
                <td></td>
                <td class=" text-center"> $ Importe </td>
            </tr>

            @foreach ($pagos as $pago)
            <tr>
                <td>
                    {{ $pago->concepto }}
                </td>
                <td></td>
                <td class="text-center">
                    {{ number_format($pago->subtotal, 2) }}
                </td>
            </tr>
            @endforeach

            <tr>
                <td colspan="3">
                    <hr />
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <h5>Detalle del pago - Cheques</h5>
                </td>
            </tr>
            <tr class="bg-secondary text-white">
                <td>Nro de cheque</td>
                <td>Banco</td>
                <td class="text-center">Importe</td>
            </tr>

            @foreach ($cheques as $cheque)
            <tr>
                <td>{{ $cheque->nrocheque }}</td>
                <td>{{ $cheque->Banco->nombre }}</td>
                <td class="text-center">{{ $cheque->importe }} </td>
            </tr>
            @endforeach

            <tr>
                <td></td>
                <td>Total cheques</td>
                <td class="text-center font-weight-bolder">
                    {{ number_format($cheques->sum('importe'), 2, ',', '.') }}</td>
            </tr>
        </table>

    </div>
</div>


@endsection


@section('js')

<script>


</script>
@stop