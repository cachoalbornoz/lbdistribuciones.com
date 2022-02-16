<div class="row">
    <div class="col-xs-12 col-sm-6 col-lg-6 mb-1">
        <div class="btn-group mr-2" role="group" aria-label="...">
            <a href="{{ route('proveedor.edit', $proveedor->id) }}" class="btn btn-primary">
                {{ $proveedor->nombreempresa }} - {{ $proveedor->apellido }} {{ $proveedor->nombres }}
            </a>
            <a href="#" class="btn btn-default">
                Saldo $ {{ $proveedor->saldo }}
            </a>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-lg-6 mb-1">
        <div class="btn-group d-flex" role="group" aria-label="...">
            <a href="{{ route('compra.compraProveedor', $proveedor->id) }}" class="btn btn-secondary w-100">Compras</a>
            <a href="{{ route('pago.pagoProveedor', $proveedor->id) }}" class="btn btn-secondary w-100">Pagos</a>
            <a href="{{ route('movproveedor.index', $proveedor->id) }}" class="btn btn-secondary w-100">Mov</a>
            <a href="{{ route('movproveedor.deuda', $proveedor->id) }}" class="btn btn-secondary w-100">Deuda</a>
        </div>
    </div>
</div>