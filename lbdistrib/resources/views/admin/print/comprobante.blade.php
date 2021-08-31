@extends('base.base-pdf')

@section('title', 'Imprimir')

@section('content')

    <table width="100%" class="text-center">
        <tr>
            <td width="33%">
                <hr>
            </td>
            <td width="33%"><img src="{{ asset('/images/frontend/letra-x.jpg') }}" class="img-thumbnail" width="50"
                    height="50"></td>
            <td width="33%">
                <hr>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> DOCUMENTO NO VALIDO COMO FACTURA </td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><br /></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td><br /></td>
            <td></td>
        </tr>
    </table>

    <table style="width:100%;">
        <tr>
            <td>RAZON SOCIAL <b>{{ $comprobante->Contacto->nombreempresa }} :: {{ $comprobante->Contacto->apellido }},
                    {{ $comprobante->Contacto->nombres }} </b> </td>
            <td>{{ $tipocomprobante->comprobante }} NRO <b>{{ $comprobante->nro }} </b></td>
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
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>

    @if ($tipocomprobante->id == 1 or $tipocomprobante->id == 2 or $tipocomprobante->id == 3 or $tipocomprobante->id == 8)
        <table class="table table-bordered text-center">
            <tr>
                <td style=" width: 5 %">#</td>
                <td style=" width: 60%">Producto</td>
                <td style=" width: 10 %">Cantidad</td>
                <td style=" width: 10 %">Precio</td>
                <td style=" width: 15 %">Subtotal</td>
            </tr>

            @foreach ($comprobante->detalleventas as $deta)
                <tr>
                    <td>#</td>
                    <td class=" text-left">
                        @if (isset($deta->Producto->nombre))
                            {{ substr($deta->Producto->nombre, 0, 60) }}
                        @else
                            Producto Actualiz/ No disponible
                        @endif
                    </td>
                    <td class=" text-bold">
                        <b>{{ $deta->cantidad }}</b>
                    </td>
                    <td class=" text-bold">
                        <b>{{ $deta->precio }}</b>
                    </td>
                    <td>
                        <b>{{ number_format($deta->subtotal + $deta->montodesc, 2) }}</b>
                    </td>
                </tr>

                <!-- Revisa si al imprimir el detalle, supera la linea 20. -->
                @if ($loop->iteration % 15 == 0)

        </table>

        <div class="page-break"></div>

        <table class="table table-bordered text-center small">
            <tr>
                <td style=" width: 5 %">#</td>
                <td style=" width: 60%">Producto</td>
                <td style=" width: 10 %">Cantidad</td>
                <td style=" width: 10 %">Precio</td>
                <td style=" width: 15 %">Subtotal</td>
            </tr>
    @endif
    <!-- Fin revision -->

    @endforeach

    <tr>
        <td style="text-align:right " colspan="4">SUBTOTAL</td>
        <td style="font-size: 1.1em">$
            {{ number_format($comprobante->detalleventas->sum('subtotal') + $comprobante->detalleventas->sum('montodesc'), 2) }}
        </td>
    </tr>
    <tr>
        @if ($comprobante->detalleventas->first()->descuento > 0)
            <td style="text-align:right" colspan="4">BONIF.
                (<b>{{ $comprobante->detalleventas->first()->descuento * 100 }}%</b>)</td>
            <td>( {{ number_format($comprobante->detalleventas->sum('montodesc'), 2) }} ) </td>
        @else
            <td colspan="4">&nbsp; </td>
            <td>&nbsp;</td>
        @endif
    </tr>
    <tr>
        <td style="text-align:right" colspan="4"><b>TOTAL $</b></td>
        <td style="font-size: 1.1em">
            $ {{ number_format($comprobante->detalleventas->sum('subtotal'), 2) }}
        </td>
    </tr>
    </table>
@else

    <!-- Detalle de cobros -->

    <div>
        Detalle de <b> efectivo </b>
        <br>
    </div>

    <table class="table">
        <tr>
            <td>Recargo</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @foreach ($comprobante->detallecobros as $deta)
            <tr>
                <td>
                    {{ $deta->recargo }}
                </td>
                <td>
                    {{ $deta->concepto }}
                </td>
                <td></td>
                <td></td>
                <td class="text-right">
                    {{ $deta->subtotal }}
                </td>
            </tr>
        @endforeach
        <tr>
            <td>Total efectivo</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right"> {{ number_format($comprobante->detallecobros->sum('subtotal'), 2) }} </td>
        </tr>
    </table>

    <div>
        Detalle de <b> cheques </b>
        <br>
    </div>

    <table class="table">
        <thead>
            <tr>
                <td>Nro cheque</td>
                <td>Fecha Vcto</td>
                <td>Banco</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>

            @foreach ($detallecheque as $detalle)
                <tr id="itemc{{ $detalle->id }}">
                    <td> {{ $detalle->nrocheque }} </td>
                    <td> {{ date('d-m-Y', strtotime($detalle->fechacobro)) }}</td>
                    <td> {{ $detalle->Banco->nombre }} </td>
                    <td> {{ $detalle->observacion }}</td>
                    <td class="text-right"> {{ $detalle->importe }} </td>
                </tr>
            @endforeach
            <tr>
                <td>Total cheques</td>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-right"> {{ number_format($detallecheque->sum('importe'), 2) }} </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Total cobrado</td>
                <td class="text-right"><b> {{ number_format($comprobante->total, 2) }} </b> </td>
            </tr>
        </tfoot>
    </table>

    @if ($ventas->count() > 0)

        <div>
            Comprobantes <b>pagados </b>
            <br>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <td>#Nro</td>
                    <td>Fecha</td>
                    <td>Tipo y Nro comprobante</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $deta)
                    <tr>
                        <td scope="row">{{ $loop->iteration }}</td>
                        <td>
                            {{ date('d-m-Y', strtotime($deta->fecha)) }}
                        </td>
                        <td>
                            {{ $deta->Tipocomprobante->comprobante }} {{ $deta->nro }}
                        </td>
                        <td class="text-right">
                            @if ($deta->tipocomprobante == 2)
                                {{ $deta->total }}
                            @else
                                - {{ $deta->total }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    @endif

    @endif

@endsection
