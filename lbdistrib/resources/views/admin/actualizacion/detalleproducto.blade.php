@if (isset($productos))

    <div class="box-footer clearfix">
        Total de productos listados :: <b>{{ $productos->count('id') }} </b>
    </div>

    <table class="table table-hover small" id="detalle" style="font-size: smaller">
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td width="35%">{{ $producto->nombre }} </td>
                    <td width="15%">@if ($producto->Marca) {{ $producto->Marca->nombre }} @endif </td>
                    <td width="10%">@if ($producto->Rubro) {{ $producto->Rubro->nombre }} @endif </td>
                    <td width="8%" class="text-center">{{ $producto->preciolista }} </td>
                    <td width="8%" class="text-center">{{ $producto->bonificacion }} </td>
                    <td width="8%" class="text-center">{{ $producto->flete }} </td>
                    <td width="8%" class="text-center">{{ $producto->margen }} </td>
                    <td width="8%">&nbsp;</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@else

    <div class="box-footer clearfix text-center">
        Seleccione los <b>Filtros</b>, cargue los <b>Nuevos valores</b>. Luego presione <i class="fa fa-bolt"
            aria-hidden="true"></i> (Aplicar actualización)
    </div>

@endif
