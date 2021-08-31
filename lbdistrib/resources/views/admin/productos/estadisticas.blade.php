@extends('base.base')

@section('title', 'Estadisticas productos')

@section('breadcrumb')
	{!! Breadcrumbs::render('venta') !!}
@stop

@section('content')

<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				Estadisticas productos vendidos
			</div>
		</div>
	</div>	

	<div class="card-body">		
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<div class="producto">
					@include('admin.productos.detallee')
				</div>
			</div>
		</div>
	</div>
</div>

@stop

@section('js')

	<script>
        
        $(function () {
            crearDataTable('estadisticas', 1, false);
        });
    
		function buscar(){

			var route 		= '{{ route('producto.estadisticas') }}';
			var token 		= $('input[name=_token]').val() ;

			$.ajax({

				url 	: route,
				headers : {'X-CSRF-TOKEN': token},
				type 	: 'GET',
				dataType: 'json',
				data 	: {palabra: $('#palabra').val()},
				success: function(data){
					$('.producto').html(data);
				}
			});
        }
        
        

	</script>

@stop
