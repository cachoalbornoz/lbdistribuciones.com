<table id="compras" class="table table-bordered table-hover small text-center">
    <thead class="bg-secondary text-white">
        <tr>
            <td style="width: 15%">Nro</td>
            <td style="width: 15%">Fecha</td>
            <td style="width: 15%">Razón social</td>
            <td style="width: 15%">Comprobante</td>
            <td style="width: 15%">Total</td>
        </tr>
    </thead>
    <tbody>
        @if (isset($compras))
            @foreach ($compras as $compra)
                <tr id="fila{{ $compra->id }}">
                    <td>
                        <a href="{{ route('detallecompra.show', $compra->id) }}">
                            {{ $compra->nro }}
                        </a>
                    </td>
                    <td>{{ date('d-m-Y', strtotime($compra->fecha)) }}</td>
                    <td>
                        @if (isset($compra->Proveedor->nombreempresa))
                            <a href="{{ route('proveedor.show', $compra->Proveedor->id) }}">
                                {{ $compra->Proveedor->nombreempresa }}
                            </a>
                        @else
                            Info no disponible
                        @endif
                    </td>
                    <td> {{ $compra->Tipocomprobante->comprobante }}</td>
                    <td> {{ number_format($compra->total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td><b> Total facturas pendientes </b></td>
            <td><b>{{ number_format($tcompra - $ncredito, 2, ',', '.') }}</b></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td>Saldo a acreditar</td>
            <td>({{ number_format($proveedor->remanente, 2, ',', '.') }})</td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
    </tfoot>
</table>
