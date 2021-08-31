@extends('base.base')

@section('title', 'Detalle pedido')

@section('breadcrumb')
	{!! Breadcrumbs::render('pedido.detalle', $pedido) !!}
@stop

@section('content')

<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">        
                <h5>Pedido</h5>
            </div>
        </div>
    </div>

	<div class="card-body">		
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<table class="table table-borderless" style="font-size: smaller">
					<tr>
						<td style="width: 15%">
							Razón social
						</td>
						<td>
							<b> {{ $pedido->Contacto->nombreempresa }} - {{ $pedido->Contacto->nombreCompleto() }} </b>
						</td>
						<td style="width: 15%"> 
							Fecha
						</td>
						<td>
							<b>{{ $pedido->fecha }} </b>
						</td>
						<td style="width: 150px">
							@can('detallepedido.facturacion')
								<a href="{{ route('print.pedido', [$pedido->id]) }}" class="btn btn-light btn-block border">
									<i class="fa fa-print text-success" aria-hidden="true"> </i> Imprimir
								</a>
							@endcan
						</td>
					</tr>
					<tr>
						<td style="width: 15%">Vendedor</td>
						<td>
							<b> {{  $pedido->Vendedor->nombrecompleto() }} </b>
						</td>
						<td style="width: 15%"> 
							Observaciones 
						</td>
						<td style="width: 15%">
							<b> {{ $pedido->observaciones }} </b>
						</td>
						<td>
							@if (is_null($pedido->estado))
								@can('detallepedido.facturacion')
									<a href="{{ route('detallepedido.facturacion', $pedido->id) }}" class="btn btn-light btn-block btn-link border">
										Facturar
									</a>
								@endcan
							@endif
						</td>
					</tr>
				</table>	
			</div>
		</div>
	</div>	
</div>

<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<table class="table table-hover table-striped table-bordered" id="tablaDetalle" style="font-size: smaller">
				<thead>
					<tr>
						<th></th>
						<th>Producto</th>
						<th width="15px">Cantidad</th>
						<th width="15px">Precio</th>
						<th width="15px">Descuento</th>
						<th width="15px">Subtotal</th>
					</tr>
				</thead>
				<tbody>

					@foreach ($detallepedido as $detalle)

					<tr id="item{{$detalle->id}}">
						<td class=" text-center">
							{{ $loop->iteration }}
						</td>
						<td>
							{{ $detalle->Producto->nombre }}
						</td>
						<td class=" text-center">
							{{ number_format($detalle->cantidad, 2) }}
						</td>
						<td class=" text-center">
							{{ $detalle->precio }}
						</td>
						<td class=" text-center">
							{{ $detalle->descuento *100 }} %
						</td>
						<td class=" text-right ">
							{{ $detalle->subtotal }}
						</td>
					</tr>

					@endforeach

					</tbody>
					<tfoot>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><p>TOTAL $ </p></td>
							<td class=" text-right"><p id="suma"> {{ number_format($detallepedido->sum('subtotal'),2) }} </p></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js')

	<script>

	</script>
@stop
