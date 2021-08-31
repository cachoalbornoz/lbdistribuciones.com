@extends('base.base')

@section('title', 'Carga pedido')

@section('content')

<div class="row">
	<div class="col-xs-12 col-md-12 col-lg-12">
        <div class="card">
        	<div class="card-header">
				Facturación pedidos
			</div>
            
			<div class="card-body">	

				<div class="col-md-6">		
					<div class="form-group">
						Razon social <b> {{ $pedido->nombreempresa }} </b> ({{ $pedido->capellido }} {{ $pedido->cnombres }})  
					</div>
					<div class="form-group">
						Fecha <b> {{ $pedido->fecha }}</b>
					</div>	
					<div class="form-group">
						Nro <b> {{ $pedido->nro }}</b>
					</div>			
				</div>	

				<div class="col-md-6">
					<div class="form-group">
						Tipo comprobante <b> {{ $pedido->comprobante }}</b>
					</div>		
					<div class="form-group">
						Vendedor <b> {{  $pedido->apellido }} {{  $pedido->nombres }} </b>
					</div>				
					<div class="form-group">
						Forma Pago <b> {{ $pedido->forma }}</b>
					</div>	
				</div>

			</div>	
		</div>	
	</div>		       
</div>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				Detalle a entregar
			</div>
			<!-- /.box-header -->
			<div class="card-body">
				
				<table class="table table-hover table-striped table-bordered text-center" id="tablaDetalle">
				<thead>
					<tr>
						<td>Pend</td>
						<td>Descripcion del producto</td>
						<th>Cant vendida</th>
						<th>Cant entregar</th>
						<td>Precio</td>
						<td>Subtotal</td>
						<td>Asentar</td>
						<th><i class="fa fa-check-square-o text-primary" aria-hidden="true"></i></th>
					</tr>
				</thead>
				<tbody>

					<form id="detallePedido" action="{{ route('carga.registrarVta') }}" method="post" onsubmit="return registrarVta();">

					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

					<input type="hidden" id="id_pedido" name="id_pedido" value="{{ $pedido->id }}">					

					@foreach ($detallepedido as $detalle)

					<tr id="item{{$detalle->id}}">
						<td>
							<a href="#" id="pendiente" onclick="pendiente({{$detalle->id}});" class="btn btn-default">
								<i class="ion-arrow-down-b text-danger" aria-hidden="true"></i>
							</a>
						</td>
						<td>
							{{ $detalle->nombre }}
						</td>
						<td>
							{!! Form::number('cantidad'.$detalle->id, $detalle->cantidad, ['id' =>'cantidad'.$detalle->id, 'class' => 'form-control text-center', 'readonly'=>'readonly']) !!}
						</td>
						<td>
							{!! Form::number('cantidadentregada'.$detalle->id, $detalle->cantidadentregada, ['id' =>'cantidadentregada'.$detalle->id, 'class' => 'form-control text-center']) !!}
						</td>
						<td>
							{{ $detalle->precio }}
						</td>
						<td>
							{!! Form::number('subtotal'.$detalle->id, $detalle->subtotal, ['id' =>'subtotal'.$detalle->id, 'class' => 'form-control text-center', 'readonly'=>'readonly']) !!}
						</td>
						<td>
							<a href="#" id="guardar" onclick="guardar({{$detalle->id}});" class="btn btn-default">
								<i class="ion-arrow-right-b text-green"></i>
							</a>	
						</td>
						<td>
							<input type="checkbox" name="revisado[]">
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
						<th>Total $</th>
						<td><h4 id="suma">{{ $detallepedido->sum('subtotal') }}</h5></td>
						<th></th>
						<td></td>
					</tr>	
				</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>	

<div class="row">
	<div class="col-xs-12 col-sm-6 col-lg-6">
		<h5><a href="{{ route('pedido.index') }}" class="btn btn-large btn-primary"> Volver </a></h5>
	</div>
	<div class="col-xs-6 text-right">
		{!! Form::submit('Registrar venta ', ['class' => 'btn btn-large btn-success']) !!}	
	</div>
</div>


<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				Pendiente de entrega
			</div>
			<!-- /.box-header -->
			<div class="card-body">
				
				<table class="table table-hover table-striped table-bordered text-center" id="tablaDetalle">
				<thead>
					<tr>
						<td style="width: 10px">Pedido</td>
						<td>Descripcion del producto</td>
						<td>Cant vendida</td>
						<td>Cant entregar</td>
						<td>Precio</td>
						<td>Subtotal</td>
						<td></td>
						<td>Asentar</td>
						<td>&nbsp;</td>
					</tr>
				</thead>
				<tbody>
					<form id="detallePendiente" action="#" method="post">
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">

					@foreach ($pendiente as $pend)

					<tr id="itemp{{$pend->id}}">
						<td>
							{{$pend->id}}
						</td>
						<td style="text-align: left;">
							{{ $pend->Producto->nombre }}
						</td>
						<td>
							{{ $pend->cantidad }}
						</td>
						<td>
							
						</td>
						<td>
							{{ $pend->precio }}
						</td>
						<td>
							{{ $pend->subtotal }}
						</td>
						<td></td>
						<td>
							
						</td>
						<td></td>			
					</tr>

					@endforeach	

					</form>
				</tbody>
				</table>
			</div>
		</div>
	</div>
</div>




@endsection

@section('js')

	<script>

	function registrarVta(){

		var cantidad	= $("input[name*='revisado']:not(checked)").length;
		
		if (($("input[name*='revisado']:checked").length)< cantidad) {
			var texto = 'Existen cantidades no confirmadas ';			
			ymz.jq_alert({title:"Información", text:texto, ok_btn:"Ok", close_fn:null});
			return false;
		}else{
			return true;
		}
	}


	function guardar(id) {	
 
 		var cantidad			= $('#cantidad'+id).val();
		var cantidadentregada	= $('#cantidadentregada'+id).val();
		var subtotalOld 		= $('#subtotal'+id).val();
		var totalOld 			= parseFloat($('#suma').text());

		
		var route 		= '{{ route('carga.update') }}';
		var token 		= $('input[name=_token]').val();		

		if(cantidadentregada == 0){

			var texto = 'Complete Cantidad Entregar ';			
			ymz.jq_alert({title:"Información", text:texto, ok_btn:"Ok", close_fn:null});	
		}
		else{

			$.ajax({

				url 	: route,
				headers : {'X-CSRF-TOKEN': token},
				type 	: 'POST',
				dataType: 'json',
				data 	: {id: id, cantidad:cantidad, cantidadentregada:cantidadentregada},
				success: function(data){		    
					
					if(cantidad > cantidadentregada){
						
						location.reload();

					}else{

						console.log(data);

						$('#subtotal'+id).val(data.subtotal);
		    			var totalNew = totalOld + data.subtotal - subtotalOld;
		    			totalNew = totalNew.toFixed(2);
						$('#suma').html(totalNew); 	            	
					}
				}
			});					
		}
	}

	function pendiente(id){

		var route 		= '{{ route('carga.pendiente') }}';
		var token 		= $('input[name=_token]').val();
		var contacto 	= {{ $pedido->contacto }};

		$.ajax({

			url 	: route,
			headers : {'X-CSRF-TOKEN': token},
			type 	: 'POST',
			dataType: 'json',
			data 	: {id: id, contacto:contacto},
			success: function(data){

				location.reload();
			}
		});	
	}

	</script>
@stop