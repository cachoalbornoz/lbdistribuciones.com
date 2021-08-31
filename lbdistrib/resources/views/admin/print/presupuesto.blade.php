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
            <td class="text-center"><b>- NO VALIDO COMO FACTURA - </b></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td></td>
        </tr>
        <tr>
            <td>CUIT <b>{{ $comprobante->Contacto->cuit }} </b> </td>
            <td>FECHA <b>{{ date('d/m/Y', strtotime($comprobante->fecha)) }} </b> </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                Observaciones: <b>{{ $comprobante->observaciones }} </b>
            </td>
            <td>PRESUPUESTO N° <b>{{ $comprobante->id }} </b></td>
        </tr>
        <tr>
            <td colspan="2">
                <hr>
            </td>
        </tr>
    </table>

    @if ($comprobante->detallepresupuesto->count() > 0)

        <table class="table table-bordered text-center" style="font-size:11px;">
            <caption>DETALLE PRESUPUESTO</caption>
            <tr>
                <td style=" width: 5 %">#</td>
                <td style=" width: 40%">Producto</td>
                <td style=" width: 5 %">PrecioVta</td>
                <td style=" width: 5 %">Cantidad</td>
                <td style=" width: 5 %">Dcto</td>
                <td style=" width: 5 %">%</td>
                <td style=" width: 10 %">Subtotal</td>
            </tr>
            @foreach ($comprobante->detallepresupuesto as $detalle)
                <tr id="fila{{ $detalle->id }}">
                    <td><b>{{ $loop->iteration }}</b></td>
                    <td class=" text-left"> {{ $detalle->Producto->nombre }} </td>
                    <td>{{ $detalle->precio }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->montodesc }} </td>
                    <td>{{ $detalle->descuento * 100 }}</td>
                    <td class=" text-right">{{ $detalle->subtotal }}</td>
                </tr>

                <!-- Revisa si al imprimir el detalle, supera la linea 20. -->
                @if ($loop->iteration % 14 == 0)

        </table>

        <div class="page-break"></div>

        <table class="table table-bordered text-center mt-4" style="font-size:11px;">
            <tr>
                <td style=" width: 5 %">#</td>
                <td style=" width: 40 %">Producto</td>
                <td style=" width: 5 %">PrecioVta</td>
                <td style=" width: 5 %">Cantidad</td>
                <td style=" width: 5 %">Dcto</td>
                <td style=" width: 5 %">%</td>
                <td style=" width: 10 %">Subtotal</td>
            </tr>

    @endif
    <!-- Fin revision -->

    @endforeach

    <tr style="font-size:11px;">
        <td class=" text-right" colspan="6"> TOTAL </td>
        <td>{{ number_format($comprobante->detallepresupuesto->sum('subtotal'), 2) }}</td>
    </tr>
    <tr>
        <td class=" text-left" colspan="7">(*) Precios más impuestos </td>
    </tr>

    </table>
@else
    <span class="text-danger"> No hay productos cargados en el presupuesto. </span>
    @endif


@endsection
