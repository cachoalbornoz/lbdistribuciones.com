<table id="ventas" class="table table-bordered table-hover small text-center">
    <thead class="bg-secondary text-white">
        <tr>
            <td style="width: 15%">Nro</td>
            <td style="width: 15%">Fecha</td>
            <td style="width: 15%">Razón social</td>
            <td style="width: 15%">Comprobante</td>
            <td style="width: 15%">Vendedor</td>
            <td style="width: 15%">Total</td>
        </tr>
    </thead>
    <tbody>
        @if (isset($ventas))
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
                            <a href="{{ route('contacto.show', $venta->Contacto->id) }}">
                                {{ $venta->Contacto->nombreempresa }}
                            </a>
                        @else
                            Info no disponible
                        @endif
                    </td>
                    <td> {{ $venta->Tipocomprobante->comprobante }}</td>
                    <td> {{ $venta->Vendedor->nombreCompleto() }}</td>
                    <td> {{ number_format($venta->total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td><b> Total facturas pendientes </b></td>
            <td><b>{{ number_format($tventa - $ncredito, 2, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td>Saldo a acreditar</td>
            <td>({{ number_format($contacto->remanente, 2, ',', '.') }})</td>
        </tr>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
    </tfoot>
</table>
