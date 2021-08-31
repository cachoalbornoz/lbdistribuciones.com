<table class="table table-bordered table-hover small text-center" id="compras">
    <thead>
        <tr class="bg-secondary text-white">
            <td style="width: 10%">Nro</td>
            <td style="width: 10%">Fecha</td>
            <td style="width: 25%">Razón social</td>
            <td style="width: 10%">Comprobante</td>
            <td style="width: 10%">Pagada</td>
            <td style="width: 10%">ReciboNro</td>
            <td style="width: 10%">Total</td>
            <td style="width: 5%"> Borrar</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($compras as $compra)
            <tr id="fila{{ $compra->id }}">
                <td>
                    <a href="{{ route('detallecompra.show', $compra->id) }}">
                        {{ $compra->nro }}
                    </a>
                </td>
                <td>{{ date('d-m-Y', strtotime($compra->fecha)) }} </td>
                <td>
                    @if (isset($compra->Proveedor->nombreempresa))
                        {{ $compra->Proveedor->nombreempresa }}
                    @else
                        Info no disponible
                    @endif
                </td>

                <td @if ($compra->tipocomprobante == 8) class=" text-danger" @endif>
                    {{ $compra->Tipocomprobante->comprobante }}
                </td>
                <td>
                    <input type="checkbox" @if ($compra->pagada == 1) checked @endif readonly />
                </td>
                <td>
                    {{ $compra->recibo }}
                </td>
                <td>
                    {{ number_format($compra->total, 2, ',', '.') }}
                </td>
                <td>
                    @if (isset($proveedor))
                        <a href="javascript:eliminarCompra({{ $compra->id }})">
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
            <td></td>
            <td>TOTAL </td>
            <td class=" font-weight-bolder">{{ number_format($compras->sum('total'), 2) }}</td>
            <td> </td>
        </tr>
    </tbody>
</table>
