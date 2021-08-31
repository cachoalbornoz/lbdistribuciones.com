@if ($detallepedido->count() > 0)
    <table class="table table-hover text-center small table-bordered" style="font-size: smaller">
        <tbody>
            <tr class=" bg-secondary">
                <th colspan="2" style="text-align: left;">Productos cargados al pedido</th>
                <th class="text-center" width="150px">Precio Vta</th>
                <th class="text-center" width="150px">Cantidad</th>
                <th class="text-center" width="150px">Subtotal</th>
                <th class="text-center" width="20px"></th>
            </tr>
            @foreach ($detallepedido as $detalle)
                <tr id="fila{{ $detalle->id }}">
                    <td width="20px" class=" bg-secondary"><b>{{ $loop->iteration }}</b></td>
                    <td style="text-align: left;"> {{ $detalle->Producto->nombre }} </td>
                    <td>{{ $detalle->precio }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>{{ $detalle->subtotal }}</td>
                    <td>
                        <button type="button" class="btn btn-link" id="eliminar" name="eliminar"
                            onclick="eliminarReg({{ $detalle->id }})" title="Quitar del pedido">
                            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <th>Total</th>
                <th>{{ number_format($detallepedido->sum('subtotal'), 2) }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>

@else
    <table class="table table-hover small table-bordered">
        <tr>
            <td>
                <span class="text-danger"> No hay productos cargados </span> en la nota de pedido.
            </td>
        </tr>
    </table>
@endif
