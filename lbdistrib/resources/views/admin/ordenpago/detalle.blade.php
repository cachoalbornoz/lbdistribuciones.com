<table class="table table-bordered table-hover small text-center" id="orden">
    <thead>
        <tr class="bg-secondary text-white">
            <td style="width: 15%">Nro</td>
            <td style="width: 15%">Editar</td>
            <td style="width: 15%">Fecha</td>
            <td style="width: 15%">Razón social</td>
            <td style="width: 15%">Comprobante</td>
            <td style="width: 15%">Total</td>
            <td> </td>
        </tr>
    </thead>
    <tbody>
        @foreach ($pagos as $pago)
            <tr id="fila{{ $pago->id }}">
                <td>
                    {{ $pago->nro }}
                </td>
                <td>
                    <a href="{{ route('detalleordenpago.index', [$pago->id]) }}">
                        <i class="fa fa-pencil"></i>
                    </a>
                </td>
                <td>{{ date('d-m-Y', strtotime($pago->fecha)) }}</td>
                <td>
                    @if (isset($pago->Proveedor->nombreempresa))
                        {{ $pago->Proveedor->nombreempresa }}
                    @else
                        Informacion no disponible
                    @endif
                </td>
                <td>{{ $pago->Tipocomprobante->comprobante }}</td>
                <td> {{ number_format($pago->total, 2, ',', '.') }}</td>
                <td>
                    @if (isset($proveedor))
                        <a href="javascript:eliminarOrden({{ $pago->id }})">
                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>TOTAL</td>
            <td>{{ number_format($pagos->sum('total'), 2) }}</td>
            <td> </td>
        </tr>
    </tbody>
</table>
