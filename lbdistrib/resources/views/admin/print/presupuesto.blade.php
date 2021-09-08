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
            <td>CUIT <b>{{ $comprobante->Contacto->cuit }} </b> </td>
            <td>FECHA <b>{{ date('d/m/Y', strtotime($comprobante->fecha)) }} </b> </td>
        </tr>
        <tr>
            <td>
                Observaciones: <b>{{ $comprobante->observaciones }} </b>
            </td>
            <td>PRESUPUESTO N° <b>{{ $comprobante->id }} </b></td>
        </tr>
    </table>

    @if ($comprobante->detallepresupuesto->count() > 0)

        <table style="width: 100%" class="text-center mt-4" style="font-size: 1em">
            <tr>
                <th style=" width: 5 %">#</th>
                <th style=" width: 40%">Producto</th>
                <th style=" width: 5 %">P.Venta</th>
                <th style=" width: 5 %">Cantidad</th>
                <th style=" width: 5 %">Dcto</th>
                <th style=" width: 5 %">%</th>
                <th style=" width: 10 %">Subtotal</th>
            </tr>
            <tr>
                <td colspan="7">
                    <hr>
                </td>
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
                <td class="text-center"><b>- NO VALIDO COMO FACTURA - </b></td>
            </tr>
            <tr>
                <td>CUIT <b>{{ $comprobante->Contacto->cuit }} </b> </td>
                <td>FECHA <b>{{ date('d/m/Y', strtotime($comprobante->fecha)) }} </b> </td>
            </tr>
            <tr>
                <td>
                    Observaciones: <b>{{ $comprobante->observaciones }} </b>
                </td>
                <td>PRESUPUESTO N° <b>{{ $comprobante->id }} </b></td>
            </tr>
        </table>

        <table style="width: 100%" class="text-center mt-4" style="font-size: 1em">
            <tr>
                <th style=" width: 5 %">#</th>
                <th style=" width: 40 %">Producto</th>
                <th style=" width: 5 %">P.Venta</th>
                <th style=" width: 5 %">Cantidad</th>
                <th style=" width: 5 %">Dcto</th>
                <th style=" width: 5 %">%</th>
                <th style=" width: 10 %">Subtotal</th>
            </tr>
            <tr>
                <td colspan="7">
                    <hr>
                </td>
            </tr>

    @endif
    <!-- Fin revision -->

    @endforeach

    <tr>
        <th colspan="7">
            <hr />
        </th>
    </tr>
    <tr>
        <th class=" text-left" colspan="5">
            (*) Precios más impuestos
        </th>
        <th>
            TOTAL
        </th>
        <th class=" text-right">{{ number_format($comprobante->detallepresupuesto->sum('subtotal'), 2) }}</th>
    </tr>

    </table>

@else
    <span class="text-danger"> No hay productos cargados en el presupuesto. </span>
    @endif


@endsection
