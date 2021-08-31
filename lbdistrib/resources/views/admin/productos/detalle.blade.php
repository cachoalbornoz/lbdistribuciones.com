<table class="table table-bordered table-hover table-condensed small text-center" style="font-size: smaller"
    id="productos">
    <thead>
        <tr>
            <td style=" width: 10%">&nbsp;</td>
            <td>Nombre del producto</td>
            <td style=" width: 10%">Stock</td>
            <td style=" width: 10%">P.Venta</td>
            <td style=" width: 10%">Marca</td>
            <td style=" width: 10%">Rubro</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto)

            <tr id="fila{{ $producto->id }}">
                <td>
                    {{ $producto->codigobarra }}
                </td>
                <td style="text-align: left;">
                    <a href="{{ route('producto.edit', $producto->id) }}">
                        {{ $producto->nombre }}
                    </a>
                </td>
                <td>
                    {{ $producto->stockactual }}
                </td>
                <td>
                    {{ number_format($producto->precioventa, 2, ',', '.') }}
                </td>
                <td>
                    @if (isset($producto->Marca->nombre)){{ $producto->Marca->nombre }}@endif
                </td>
                <td>
                    @if (isset($producto->Rubro->nombre)){{ $producto->Rubro->nombre }}@endif
                </td>
            </tr>

        @endforeach
    </tbody>
</table>
