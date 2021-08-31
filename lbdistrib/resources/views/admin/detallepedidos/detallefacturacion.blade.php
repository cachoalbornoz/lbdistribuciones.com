<table class="table table-hover table-condensed table-bordered text-center" style="font-size: smaller"
    id="tablaDetalle">
    <tr class=" bg-light">
        <th>PRODUCTO</th>
        <th>$ PRECIO</th>
        <th>PEDIDOS</th>
        <th class=" text-info">A ENTREGAR</th>
        <th class=" text-danger">FALTANTES</th>

    </tr>

    @foreach ($detallepedido as $detalle)
        <tr>
            <td class=" w-50" style="text-align: left;">
                <strong>{{ $loop->iteration }}</strong> - {{ $detalle->Producto->nombre }}
            </td>
            <td style="width: 10%">
                {{ number_format($detalle->Producto->precioventa, 2) }}
            </td>
            <td style="width: 10%">
                <input id="cantidad{{ $detalle->producto }}" name="cantidad{{ $detalle->producto }}" type="number"
                    value="{{ $detalle->cantidad }}" class="form-control text-center" readonly disabled />
            </td>
            <td style="width: 10%">
                @if ($detalle->cantidadentregada > 0)
                    <input id="cantidadentregada{{ $detalle->producto }}"
                        name="cantidadentregada{{ $detalle->producto }}" type="number"
                        value="{{ $detalle->cantidadentregada }}" class="form-control text-center"
                        onblur="actualizar({{ $detalle->id }},{{ $detalle->producto }})" step="any" />
                @else
                    <input id="cantidadentregada{{ $detalle->producto }}"
                        name="cantidadentregada{{ $detalle->producto }}" type="number" value="0"
                        class="form-control text-center"
                        onblur="actualizar({{ $detalle->id }},{{ $detalle->producto }})" step="any" />
                @endif
            </td>
            <td style="width: 10%">

            </td>
        </tr>
    @endforeach
</table>
