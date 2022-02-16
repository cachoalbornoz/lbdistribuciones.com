<div class="row">
    <div class="col-xs-12 col-sm-6 col-lg-6 mb-1">
        <div class="btn-group mr-2" role="group" aria-label="...">
            <a href="{{ route('contacto.edit', $contacto->id) }}" class="btn btn-primary">
                {{ $contacto->nombreempresa }} - {{ $contacto->apellido }} {{ $contacto->nombres }}
            </a>
            <a href="#" class="btn btn-default">
                Saldo $
                <span class="   @if ($contacto->saldo - $contacto->remanente < 0)
                        text-danger
                        @endif">
                    {{ number_format($contacto->saldo - $contacto->remanente, 2) }}
                </span>
            </a>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-lg-6 mb-1">
        <div class="btn-group d-flex" role="group" aria-label="..">
            <a href="{{ route('venta.ventaContacto', $contacto->id) }}" class="btn btn-secondary w-100">Ventas</a>
            <a href="{{ route('cobro.cobroContacto', $contacto->id) }}" class="btn btn-secondary w-100">Cobros</a>
            <a href="{{ route('movcontacto.index', $contacto->id) }}" class="btn btn-secondary w-100">Mov</a>
            <a href="{{ route('movcontacto.deuda', $contacto->id) }}" class="btn btn-secondary w-100">Deuda</a>
        </div>
    </div>
</div>