<table class="table table-hover table-bordered text-center" id="tablaDetalle">
<thead>
	<tr>
		<td>#Nro Item</td>
		<td>Descripcion del producto</td>
		<td>$ Precio</td>
		<td>Cantidad pedida</td>
		<td>Cantidad entregar</td>
	</tr>
</thead>
<tbody>

	@foreach ($detallepresupuesto as $detalle)
	<tr>
		<td>
			{{ $loop->iteration }}
		</td>
		<td style="text-align: left;">
			{{ $detalle->Producto->nombre }}
		</td>
		<td>
			{{ number_format($detalle->Producto->precioventa,2) }}
		</td>
		<td>
			<input id="cantidad{{ $detalle->producto }}" name="cantidad{{ $detalle->producto }}" type="number" value="{{ $detalle->cantidad }}" class="form-control text-center" readonly disabled />
		</td>
		<td style="width: 20%" >
			@if ($detalle->cantidadentregada > 0)
				<input id="cantidadentregada{{ $detalle->producto }}" name="cantidadentregada{{ $detalle->producto }}" type="number" value="{{ $detalle->cantidadentregada }}" class="form-control text-center" onblur="actualizar({{ $detalle->id }},{{ $detalle->producto }})"/>	
			@else
				<input id="cantidadentregada{{ $detalle->producto }}" name="cantidadentregada{{ $detalle->producto }}" type="number" value="0" class="form-control text-center" onblur="actualizar({{ $detalle->id }},{{ $detalle->producto }})"/>
			@endif			
		</td>
	</tr>

	@endforeach
</tbody>
</table>