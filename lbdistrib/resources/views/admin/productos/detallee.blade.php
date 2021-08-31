<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        &nbsp;
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-lg-12">

    </div>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-hover small" style="font-size: smaller" id="estadisticas">
        <thead>
            <tr>
                <td class="text-center">Codigo</td>
                <td>Nombre del producto</td>
                <td class="text-center">Marca</td>
            </tr>
        </thead>

        @foreach ($productos as $producto)
            <tr id="fila{{ $producto->id }}">
                <td class="text-center">
                    {{ $producto->codigobarra }}
                </td>
                <td>
                    <a href="{{ route('producto.detalleestadistica', $producto->id) }}">
                        {{ $producto->nombre }}
                    </a>
                </td>
                <td class="text-center">
                    {{ $producto->marca }}
                </td>
            </tr>
        @endforeach
    </table>
</div>
