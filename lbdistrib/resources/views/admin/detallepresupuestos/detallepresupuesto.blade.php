@if ($detallepresupuesto->count() > 0)

<table id="detallePresupuesto" class="table table-condensed table-hover text-center table-sm small table-bordered" style="font-size: smaller">
    <thead>
        <tr class=" bg-secondary text-white">
            <td>#</td>
            <td>Detalle del presupuesto</td>
            <td class="text-center" width="150px">Precio Vta</td>
            <td class="text-center" width="150px">Cantidad</td>
            <td class="text-center" width="150px">Subtotal</td>
            <td class="text-center" width="20px"></td>
        </tr>
    </thead>
    <tbody>
        @foreach ($detallepresupuesto as $detalle)
        <tr id="fila{{ $detalle->id }}">
            <td width="20px" class=" bg-secondary text-white"><b>{{ $loop->iteration }}</b></td>
            <td style="text-align: left;"> {{ $detalle->Producto->nombre }} </td>
            <td>{{ $detalle->precio }}</td>
            <td>{{ $detalle->cantidad }}</td>
            <td>{{ $detalle->subtotal }}</td>
            <td>
                <a href="javascript:eliminarReg({{ $detalle->id }})" id="eliminar" name="eliminar" title="Quitar del presupuesto">
                    <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td style="text-align: left;">Productos cargados <strong> {{ $detallepresupuesto->count('id') }} </strong></td>
            <td></td>
            <th>TOTAL</th>
            <th>
                {{ number_format($detallepresupuesto->sum('subtotal'), 2, ',', '.') }}
            </th>
            <td>
                </th>
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