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
            <td>CUIT <b>{{ $comprobante->Contacto->cuit }} </b> </td>
            <td>FECHA <b>{{ date('d/m/Y', strtotime($comprobante->fecha)) }} </b> </td>
        </tr>
        <tr>
            <td colspan="2">
                Observaciones: <b>{{ $comprobante->observaciones }} </b>
            </td>
        </tr>

    </table>

    @if ($comprobante->detallepedido->count() > 0)

        <table style="width: 100%" class="text-center mt-4" style="font-size: 1em">
            <tr>
                <th style=" width: 5 %">#</th>
                <th style=" width: 70%">Producto</th>
                <th style=" width: 5 %">P.Venta</th>
                <th style=" width: 5 %">Cantidad</th>
                <th style=" width: 15 %">Subtotal</th>
            </tr>
            <tr>
                <th colspan="5">
                    <hr>
                </th>
            </tr>

            @foreach ($comprobante->detallepedido as $detalle)

                <tr id="fila{{ $detalle->id }}">
                    <td><b>{{ $loop->iteration }}</b></td>
                    <td class=" text-left"> {{ $detalle->Producto->nombre }} </td>
                    <td>{{ $detalle->precio }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->subtotal, 2, ',', '.') }}</td>
                </tr>

                <!-- Revisa si al imprimir el detalle, supera la linea 20. -->
                @if ($loop->iteration % 34 == 0)

        </table>

        <div class="page-break"></div>

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
                <td>RAZON SOCIAL <b>{{ $comprobante->Contacto->nombreempresa }} ::
                        {{ $comprobante->Contacto->apellido }},
                        {{ $comprobante->Contacto->nombres }} </b> </td>
                <td>{{ $tipocomprobante->comprobante }} NRO <b>{{ $comprobante->id }} </b></td>
            </tr>
            <tr>
                <td>CUIT <b>{{ $comprobante->Contacto->cuit }} </b> </td>
                <td>FECHA <b>{{ date('d/m/Y', strtotime($comprobante->fecha)) }} </b> </td>
            </tr>
            <tr>
                <td colspan="2">
                    Observaciones: <b>{{ $comprobante->observaciones }} </b>
                </td>
            </tr>
        </table>

        <table style="width: 100%" class="text-center mt-4" style="font-size: 1em">
            <tr>
                <th style=" width: 5 %">#</th>
                <th style=" width: 70%">Producto</th>
                <th style=" width: 5 %">P.Venta</th>
                <th style=" width: 5 %">Cantidad</th>
                <th style=" width: 15 %">Subtotal</th>
            </tr>
            <tr>
                <th colspan="5">
                    <hr>
                </th>
            </tr>
    @endif
    <!-- Fin revision -->

    @endforeach

    <tr>
        <th colspan="5">
            <hr>
        </th>
    </tr>

    <tr>
        <th class=" text-right" colspan="4"> TOTAL </th>
        <th>{{ number_format($comprobante->detallepedido->sum('subtotal'), 2, ',', '.') }}</th>
    </tr>

    </table>
@else
    <span class="text-danger"> No hay productos cargados en el pedido. </span>
    @endif


@endsection
