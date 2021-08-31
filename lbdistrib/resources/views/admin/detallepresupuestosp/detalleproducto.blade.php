<table class="table table-hover text-center small" style="font-size: smaller">
    <thead>
        <tr>
            <th> </th>
            <th width="150px">Foto </th>
            <th width="150px">Precio venta </th>
            <th width="150px">Descuento </th>
            <th width="150px">Stock</th>
            <th width="150px">Cantidad </th>
            <th width=" 20px"> </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productos as $producto)
            <tr>
                <td style="text-align: left;">
                    {{ $producto->nombre }}
                </td>
                <td>
                    @if (isset($producto->image) and is_file(public_path('images/upload/productos/' . $producto->image)))
                        <a href="{{ asset('images/upload/productos/' . $producto->image) }}" data-fancybox="gallery"
                            data-caption="&lt;b&gt;{{ $producto->nombre }}&lt;/b&gt;&lt;br /&gt;Precio Venta $ {{ $producto->preciolista }} ">
                            <img src="{{ asset('images/upload/productos/' . $producto->image) }}" class="img-rounded"
                                height="50px" width="50px" title="Click para aumentar foto">
                        </a>
                    @else
                        <img src="{{ asset('images/frontend/imagen-no-disponible.png') }}" class="img-rounded"
                            height="50px" width="50px">
                    @endif
                </td>
                <td>
                    <input type="number" name="precio{{ $producto->id }}" id="precio{{ $producto->id }}"
                        class="form-control text-center" value="{{ $producto->preciolista }}" />
                </td>
                <td>
                    <input type="number" name="descuento{{ $producto->id }}" id="descuento{{ $producto->id }}"
                        class="form-control text-center" value="0" title="Cargue un valor entre 0 y 1" />
                </td>
                <td>
                    <input type="number" name="stock{{ $producto->id }}" id="stock{{ $producto->id }}"
                        class="form-control text-center" value="{{ $producto->stockactual }}" disabled="true" />
                </td>
                <td>
                    <input type="number" name="cantidad{{ $producto->id }}" id="cantidad{{ $producto->id }}"
                        class="form-control text-center" value="1" />
                </td>
                <td>
                    <button id="{{ $producto->id }}" class="btn btn-primary btn-sm" onclick="guardar(this.id)">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">
                Total de productos listados :: <b>{{ $productos->total() }} </b>
                {{ $productos->appends(Request::all())->links() }}
            </td>
        </tr>
    </tfoot>
</table>
