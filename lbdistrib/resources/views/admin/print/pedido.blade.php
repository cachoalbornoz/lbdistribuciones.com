@extends('base.base-pdf')

@section('title', 'Imprimir')

@section('content')

    <table width="100%" class="text-center">
        <tr>
            <td width="33%">
                <hr>
            </td>
            <td width="33%"></td>
            <td width="33%">
                <hr>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <td>RAZON SOCIAL <b>{{ $comprobante->Contacto->nombreempresa }} :: {{ $comprobante->Contacto->apellido }},
                    {{ $comprobante->Contacto->nombres }} </b> </td>
            <td>{{ $tipocomprobante->comprobante }} NRO <b>{{ $comprobante->id }} </b></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>CUIT <b>{{ $comprobante->Contacto->cuit }} </b> </td>
            <td>FECHA <b>{{ date('d/m/Y', strtotime($comprobante->fecha)) }} </b> </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                Observaciones: <b>{{ $comprobante->observaciones }} </b>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <hr>
            </td>
        </tr>
    </table>

    @if ($comprobante->detallepedido->count() > 0)

        <table class="table table-bordered" style="font-size:11px;">
            <caption>DETALLE PEDIDO</caption>
            <tr>
                <td style=" width: 5 %">#</td>
                <td style=" width: 70%">Producto</td>
                <td style=" width: 5 %">PrecioVta</td>
                <td style=" width: 5 %">Cantidad</td>
                <td style=" width: 15 %">Subtotal</td>
            </tr>

            @foreach ($comprobante->detallepedido as $detalle)

                <tr id="fila{{ $detalle->id }}">
                    <td><b>{{ $loop->iteration }}</b></td>
                    <td style="text-align: left;"> {{ $detalle->Producto->nombre }} </td>
                    <td>{{ $detalle->precio }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td class=" text-right">{{ $detalle->subtotal }}</td>
                </tr>

                <!-- Revisa si al imprimir el detalle, supera la linea 20. -->
                @if ($loop->iteration % 19 == 0)

        </table>

        <div class="page-break"></div>

        <table class="table table-bordered" style="font-size:11px;">
            <tr>
                <td style=" width: 5 %">#</td>
                <td style=" width: 70%">Producto</td>
                <td style=" width: 5 %">PrecioVta</td>
                <td style=" width: 5 %">Cantidad</td>
                <td style=" width: 15 %">Subtotal</td>
            </tr>

    @endif
    <!-- Fin revision -->

    @endforeach


    <tr style="font-size:11px;">
        <td class=" text-right" colspan="4"> TOTAL </td>
        <td>{{ number_format($comprobante->detallepedido->sum('subtotal'), 2) }}</td>
    </tr>

    </table>
@else
    <span class="text-danger"> No hay productos cargados en el pedido. </span>
    @endif


@endsection
