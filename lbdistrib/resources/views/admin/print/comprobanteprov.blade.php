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
    </table>

    <table width="100%">
        <tr>
            <td>Razón social <b>{{ $comprobante->Proveedor->nombreempresa }} :: {{ $comprobante->Proveedor->apellido }},
                    {{ $comprobante->Proveedor->nombres }} </b> </td>
            <td>{{ $tipocomprobante->comprobante }} Nro <b>{{ $comprobante->nro }} </b></td>
        </tr>
        <tr>
            <td>Cuit <b>{{ $comprobante->Proveedor->cuit }} </b> </td>
            <td>Fecha <b>{{ date('d/m/Y', strtotime($comprobante->fecha)) }} </b> </td>
        </tr>
        <tr>
            <td colspan="2">Obs :: <strong> {{ $comprobante->observaciones }} </strong> </td>
        </tr>
        <tr>
            <td colspan="2">
                &nbsp;
            </td>
        </tr>
    </table>

    @if ($tipocomprobante->id == 2 or $tipocomprobante->id == 3 or $tipocomprobante->id == 8)
        <table class="table small" style=" font-size: 1em">
            <tr>
                <th class="text-center">Producto</td>
                <th class="text-center">Cant</th>
                <th class="text-center">$</th>
                <th class="text-center">Desc</th>
                <th class="text-center">Otros</th>
                <th class="text-center">Total</th>
            </tr>
            @foreach ($comprobante->detallecompras as $deta)
                <tr>
                    <td style="width:75%;text-align: left;">
                        @if (isset($deta->Producto->nombre))
                            {{ $deta->Producto->nombre }}
                        @else
                            Producto Actualiz/ No disponible
                        @endif
                    </td>
                    <td class="width:5%; text-center">
                        {{ $deta->cantidad }}
                    </td>
                    <td class="width:5%; text-center">
                        {{ number_format($deta->precio, 0, ',', '.') }}
                    </td>
                    <td class="width:5%; text-center">
                        {{ number_format($deta->montodesc, 0, ',', '.') }}
                    </td>
                    <td class="width:5%; text-center">
                        {{ number_format($deta->montodesc1, 0, ',', '.') }}
                    </td>
                    <td class="width:5%; text-center">
                        {{ number_format($deta->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6"></td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>Desc</td>
                <td class=" text-center">{{ number_format($comprobante->detallecompras->sum('montodesc'), 0, '.', ',') }}
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>Otros</td>
                <td class="text-center">{{ number_format($comprobante->detallecompras->sum('montodesc1'), 0, '.', ',') }}
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td>Iva</td>
                <td class="text-center">{{ number_format($comprobante->detallecompras->sum('montoiva'), 0, '.', ',') }}
                </td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <th>Total</th>
                <td class="text-center font-weight-bold">
                    {{ number_format($comprobante->detallecompras->sum('subtotal'), 0, ',', '.') }} </td>
            </tr>

        </table>
    @else
        <table class="table table-bordered text-center">
            <tr>
                <td>#</td>
                <td>Forma pago</td>
                <td>Importe</td>
                <td>Recargo</td>
                <td>Observaciones</td>
                <td>Subtotal</td>
            </tr>
            @foreach ($comprobante->detallepagos as $deta)
                <tr>
                    <td></td>
                    <td style="text-align: left;">
                        {{ $deta->Tipopago->tipopago }}
                    </td>
                    <td>
                        {{ $deta->importe }}
                    </td>
                    <td>
                        {{ $deta->recargo }}
                    </td>
                    <td>
                        {{ $deta->recargo }}
                    </td>
                    <td>
                        {{ $deta->subtotal }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Total $ </td>
                <td><b> {{ $comprobante->total }} </b></td>
            </tr>
        </table>

    @endif



@endsection
