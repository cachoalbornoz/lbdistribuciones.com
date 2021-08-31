@if ($detallepresupuesto->count() > 0)

    <table class="table table-hover text-center small table-bordered" style="font-size: smaller">
        <tbody>
            <tr class=" bg-secondary text-white">
                <td colspan="2" style="text-align: left;">Detalle del presupuesto</td>
                <td class="text-center" width="150px">Precio venta</td>
                <td class="text-center" width="150px">Descuento</td>
                <td class="text-center" width="150px">Cantidad</td>
                <td class="text-center" width="150px">Subtotal</td>
                <td class="text-center" width="20px"></td>
            </tr>
            @foreach ($detallepresupuesto as $detalle)
                <tr id="fila{{ $detalle->id }}">
                    <td width="20px" class=" bg-secondary text-white">
                        {{ $loop->iteration }}
                    </td>
                    <td style="text-align: left;"> {{ $detalle->Producto->nombre }} </td>
                    <td>{{ $detalle->precio }}</td>
                    <td>{{ $detalle->descuento > 0 ? $detalle->descuento * 100 : 0 }} %</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ number_format($detalle->subtotal, 2, ',', '.') }}</td>
                    <td>
                        <button type="button" class="btn btn-link" id="eliminar" name="eliminar"
                            onclick="eliminarReg({{ $detalle->id }})" title="Quitar del presupuesto">
                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4"></th>
                <th>TOTAL</th>
                <th>
                    <h6>{{ number_format($detallepresupuesto->sum('subtotal'), 2, ',', '.') }}</h6>
                </th>
                <th></th>
            </tr>
        </tfoot>
    </table>

@else
    <table class="table table-hover small table-bordered">
        <tr>
            <td>
                <span class="text-danger"> No hay productos cargados </span> en el presupuesto.
            </td>
        </tr>
    </table>
@endif
