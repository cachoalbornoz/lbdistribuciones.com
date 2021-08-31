@if (isset($detallecompra))

@foreach ($detallecompra as $detalle)
<div class="row mt-4 text-center">
    <div class="col-xs-12 col-sm-6 col-lg-6 text-left">
        {{ substr($detalle->Producto->nombre,0,100) }}
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
        {{ $detalle->cantidad }}
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
        {{ $detalle->precio }}
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
        {{ $detalle->montodesc  }}
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
        {{ $detalle->montodesc1 }}
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
        {{ $detalle->montoiva }}
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
        {{ number_format($detalle->subtotal, 2, ',', '.') }}
        <a href="#" onclick="borrarReg({{ $detalle->id }});">
            <i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
        </a>
    </div>
</div>

@endforeach
<div class="row mt-2">
    <div class="col-xs-12 col-sm-12 col-lg-12">
        <hr>
    </div>
</div>
<div class="row mt-4 text-center font-weight-bold">
    <div class="col-xs-12 col-sm-6 col-lg-6">
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
        TOTAL
    </div>
    <div class="col-xs-12 col-sm-1 col-lg-1">
        <input type="hidden" id="total" name="total" value="{{ $detallecompra->sum('subtotal') }}" />
        {{ number_format($detallecompra->sum('subtotal'), 2, ',', '.') }}
    </div>
</div>
@endif