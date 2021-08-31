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

    <table class="table small table-condensed text-center table-borderless" style="font-size:11px;">
        <caption style="font-size: 1.2em"> Orden de Pago - comprobantes autorizados </caption>
        <thead>
            <tr>
                <td>Nro</td>
                <td>Fecha Compra</td>
                <td>Comprobante </td>
                <td>$ Importe </td>
                <td>Nro Orden</td>
                <td>F. Autorizacion</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($compras as $compra)
                <tr>
                    <td>
                        {{ $compra->nro }}
                    </td>
                    <td>
                        {{ date('d-m-Y', strtotime($compra->fecha)) }}
                    </td>
                    <td>
                        {{ $compra->Tipocomprobante->comprobante }}
                    </td>
                    <td>
                        {{ $compra->total }}
                    </td>
                    <td>
                        {{ $compra->orden }}
                    </td>
                    <td>
                        {{ date('d-m-Y', strtotime($compra->fechaautorizacion)) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
