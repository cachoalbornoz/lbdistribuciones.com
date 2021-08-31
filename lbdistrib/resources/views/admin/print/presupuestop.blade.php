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
            <td>RAZON SOCIAL PROVEEDOR<b>{{ $comprobante->Proveedor->razonsocial }} ::
                    {{ $comprobante->Proveedor->apellido }}, {{ $comprobante->Proveedor->nombres }} </b> </td>
            <td class="text-center"></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td></td>
        </tr>
        <tr>
            <td>CUIT <b>{{ $comprobante->Proveedor->cuit }} </b> </td>
            <td>FECHA <b>{{ date('d/m/Y', strtotime($comprobante->fecha)) }} </b> </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td></td>
        </tr>
        <tr>
            <td>
                Observaciones: <b>{{ $comprobante->observaciones }} </b>
            </td>
            <td></td>
        </tr>
        <tr>
            <td colspan="2">
                <hr>
            </td>
        </tr>
    </table>

    @if ($comprobante->detallepresupuesto->count() > 0)

        <table class="table table-bordered" style="font-size:10px;">
            <caption>DETALLE PRESUPUESTO</caption>
            <tr>
                <td style=" width: 5 %">#</td>
                <td style=" width: 50%">Producto</td>
                <td style=" width: 5 %">P.Vta</td>
                <td style=" width: 5 %">Dcto</td>
                <td style=" width: 5 %">Cant</td>
                <td style=" width: 10 %">Subtotal</td>
            </tr>
            @foreach ($comprobante->detallepresupuesto as $detalle)
                <tr id="fila{{ $detalle->id }}">
                    <td><b>{{ $loop->iteration }}</b></td>
                    <td> {{ $detalle->Producto->nombre }} </td>
                    <td class=" text-center">{{ $detalle->precio }}</td>
                    <td class=" text-center">{{ $detalle->descuento > 0 ? $detalle->descuento * 100 : 0 }} %</td>
                    <td class=" text-center">{{ $detalle->cantidad }}</td>
                    <td class=" text-right">{{ number_format($detalle->subtotal, 2, ',', '.') }}</td>
                </tr>


                <!-- Revisa si al imprimir el detalle, supera la linea 20. -->

                @if ($loop->iteration % 19 == 0)
        </table>

        <div class="page-break"></div>

        <table class="table table-bordered" style="font-size:10px;">

            <tr>
                <td style=" width: 5 %">#</td>
                <td style=" width: 50%">Producto</td>
                <td style=" width: 5 %">P.Vta</td>
                <td style=" width: 5 %">Dcto</td>
                <td style=" width: 5 %">Cant</td>
                <td style=" width: 10 %">Subtotal</td>
            </tr>
    @endif
    <!-- Fin revision -->

    @endforeach

    <tr>
        <td colspan="6">&nbsp;</td>
    </tr>
    <tr>
        <th colspan="5"> TOTAL </th>
        <th>{{ number_format($comprobante->detallepresupuesto->sum('subtotal'), 2, ',', '.') }}</th>
    </tr>
    <tr>
        <td class=" text-left" colspan="6">(*) Precios más impuestos </td>
    </tr>

    </table>
@else
    <span class="text-danger"> No hay productos cargados en el presupuesto. </span>
    @endif


@endsection
