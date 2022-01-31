<div class="row text-center bg-secondary text-white mb-2">
	<div class="col-1">#Nro</div>
	<div class="col-4">Descripcion del producto</div>
	<div class="col-1">$ Precio</div>
	<div class="col-1">Pedida</div>
	<div class="col-1">Cant entregar</div>
	<div class="col-1">$ Subtotal</div>
	<div class="col-2"></div>
</div>

@foreach ($detallepresupuesto as $detalle)
<div class="row text-center">
	<div class="col-1"> {{ $loop->iteration }}</div>
	<div class="col-4 text-left"> {{ $detalle->Producto->nombre }} </div>
	<div class="col-1"> {{ number_format($detalle->Producto->precioventa,2) }} </div>
	<div class="col-1"> <input id="cantidad{{ $detalle->producto }}" name="cantidad{{ $detalle->producto }}" type="number" value="{{ $detalle->cantidad }}" class="form-control text-center" readonly disabled /> </div>
	<div class="col-1"> <input id="cantidadentregada{{ $detalle->producto }}" name="cantidadentregada{{ $detalle->producto }}" type="number" value="{{ $detalle->cantidadentregada }}" class='form-control text-center actualizar @if($detalle->cantidad > $detalle->cantidadentregada) text-danger @endif' onchange="actualizar({{ $detalle->id }},{{ $detalle->producto }})" /></div>
	<div class="col-1"> <input id="subtotal{{ $detalle->producto}} type=" number" value="{{ number_format($detalle->Producto->precioventa*$detalle->cantidadentregada,2) }}" class="form-control text-center" readonly disabled /></div>
	<div class="col-2">
		<input type="checkbox" class="chequeada" @if (isset($detalle->cantidadentregada)) checked @endif readonly>
		@if (!isset($detalle->cantidadentregada)) <a href="javascript:void(0)" class="text-danger">Complete Cant entregar</a> @else Ok @endif
	</div>
</div>
@endforeach

<div class="row mb-3 text-center mt-3">
	<div class="col-1"> </div>
	<div class="col-4"> </div>
	<div class="col-1"> <input id="items" type="hidden" class="form-control text-center"></div>
	<div class="col-1"> {{ number_format($detallepresupuesto->sum('cantidad'),2) }} </div>
	<div class="col-1"> {{ number_format($detallepresupuesto->sum('cantidadentregada'),2) }} </div>
	<div class="col-1"> {{ number_format($detallepresupuesto->sum('subtotal'),2) }} </div>
	<div class="col-2"> </div>
</div>