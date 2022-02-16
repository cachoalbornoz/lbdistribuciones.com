<table class="table table-bordered table-hover small text-center" id="pagos">
    <thead>
        <tr class="bg-secondary text-white">
            <td style="width: 15%">Nro</td>
            <td style="width: 15%">Fecha</td>
            <td style="width: 15%">Razón social</td>
            <td style="width: 15%">Comprobante</td>
            <td style="width: 15%">Total</td>
            <td style="width: 15%">Borrar </td>
        </tr>
    </thead>
    <tbody>
        @foreach ($pagos as $pago)
        <tr id="fila{{ $pago->id }}">
            <td>
                @if ($pago->cerrado == 1)
                <a href="{{ route('detallepago.show', [$pago->id]) }}">
                    {{ $pago->nro }} -
                </a>
                @else
                <a href="{{ route('detallepago.index', [$pago->id]) }}">
                    Pagar
                </a>
                @endif
            </td>
            <td>{{ date('d-m-Y', strtotime($pago->fecha)) }}</td>
            <td>
                @if (isset($pago->Proveedor->nombreempresa))
                {{ $pago->Proveedor->nombreempresa }}
                @else
                Informacion no disponible
                @endif
            </td>
            <td>
                @if($pago->tipocomprobante == 16) Pago @else {{ $pago->Tipocomprobante->comprobante }} @endif
            </td>
            <td> {{ number_format($pago->total, 2, ',', '.') }}</td>
            <td>
                @if (isset($proveedor))
                <a href="javascript:eliminarPago({{ $pago->id }})">
                    <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
        <tr class=" font-weight-bolder">
            <td></td>
            <td></td>
            <td></td>
            <td>TOTAL</td>
            <td>{{ number_format($pagos->sum('total'), 2) }}</td>
            <td> </td>
        </tr>
    </tbody>
</table>