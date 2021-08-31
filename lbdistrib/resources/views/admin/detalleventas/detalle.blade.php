@if (isset($detalleventa))
    @foreach ($detalleventa as $detalle)
        <div class="row text-center">
            <div class="col-xs-12 col-sm-6 col-lg-6">{{ $detalle->Producto->nombre }}</div>
            <div class="col-xs-12 col-sm-1 col-lg-1">{{ $detalle->cantidad }}</div>
            <div class="col-xs-12 col-sm-1 col-lg-1">{{ $detalle->precio }}</div>
            <div class="col-xs-12 col-sm-1 col-lg-1">{{ $detalle->descuento * 100 }} %</div>
            <div class="col-xs-12 col-sm-2 col-lg-2"></div>
            <div class="col-xs-12 col-sm-1 col-lg-1">
                {{ $detalle->subtotal }} &nbsp;
                <a href="#" onclick="borrarReg({{ $detalle->id }});">
                    <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    @endforeach
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <hr />
        </div>
    </div>
    <div class="row text-center mt-4 font-weight-bolder">
        <div class="col-xs-12 col-sm-8 col-lg-8"></div>
        <div class="col-xs-12 col-sm-2 col-lg-2"></div>
        <div class="col-xs-12 col-sm-1 col-lg-1">TOTAL VENTAS $</div>
        <div class="col-xs-12 col-sm-1 col-lg-1">
            <input type="hidden" id="total" name="total" value="{{ $detalleventa->sum('subtotal') }}" />
            {{ number_format($detalleventa->sum('subtotal'), 2) }}
        </div>
    </div>

@endif
