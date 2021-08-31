<table id="ventas" class="table table-bordered table-hover small text-center">
    <thead class="bg-secondary text-white">
        <tr>
            <td style="width: 15%">Nro </td>
            <td style="width: 15%">Fecha</td>
            <td style="width: 15%">Razón social</td>
            <td style="width: 15%">Comprobante</td>
            <td style="width: 15%">Cobrada</td>
            <td style="width: 15%">Nro Recibo</td>
            <td style="width: 15%">Total</td>
            <td style="width: 15px"> </td>
        </tr>
    </thead>
    <tbody>
        @foreach ($ventas as $venta)
            <tr id="fila{{ $venta->id }}">
                <td>
                    <a href="{{ route('detalleventa.show', $venta->id) }}">
                        {{ $venta->nro }}
                    </a>
                </td>
                <td>{{ date('d-m-Y', strtotime($venta->fecha)) }}</td>
                <td>
                    @if (isset($venta->Contacto->nombreempresa))
                        {{ $venta->Contacto->nombreempresa }}
                    @else
                        Info no disponible
                    @endif
                </td>
                <td @if ($venta->tipocomprobante == 8) class=" text-danger" @endif>
                    {{ $venta->Tipocomprobante->comprobante }}
                </td>
                <td>
                    <input type="checkbox" @if ($venta->pagada == 1) checked @endif readonly>
                </td>
                <td>
                    {{ $venta->recibo }}
                </td>
                <td @if ($venta->tipocomprobante == 8) class=" text-danger" @endif>
                    {{ number_format($venta->total, 2, ',', '.') }}
                </td>
                <td>
                    @if (isset($contacto))
                        <a href="javascript:eliminarVenta({{ $venta->id }})">
                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                        </a>
                    @endif
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
            <td></td>
            <td><b> TOTAL VENTA </b></td>
            <td><b>{{ number_format($total, 2, ',', '.') }}</b></td>
            <td> </td>
        </tr>
    </tfoot>
</table>
