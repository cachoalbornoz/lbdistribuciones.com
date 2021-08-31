@extends('base.base')

@section('title', 'Listado cheques')

@section('breadcrumb')
	{!! Breadcrumbs::render('cheque') !!}
@endsection

@section('content')

	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-lg-6">			
					<h5>
					Cartera de Cheques
					@can('contacto.create')
						<small>
							<a href="{{ route('cheque.create') }}" class="btn btn-link">(+) Crear</a>
						</small>
					@endcan
					</h5>
				</div>	

				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

					{{ Form::open(['url' => 'cheque/buscar', 'class' => 'form-ajax form-inline']) }}
						<div class="form-group">
							<button type="button" class="btn btn-primary"> 
								Filtrar
							</button>
						</div>
						<div class="form-group">
							{!! Form::date('desde', \Carbon\Carbon::now()->subMonth(), ['id' => 'desde', 'class' => 'form-control text-center', 'placeholder' => 'fecha desde']) !!}
						</div>
						<div class="form-group">
							{!! Form::date('hasta', \Carbon\Carbon::now(), ['id' => 'hasta', 'class' => 'form-control text-center', 'placeholder' => 'fecha desde']) !!}
						</div>
						<div class="form-group">
							Banco
							{!! Form::select('banco', $banco, null, ['id' =>'banco', 'class' => 'form-control', 'placeholder' => 'Banco ...']) !!}
						</div>

						<div class="form-group">
							<button type="button" id="filtro" class="btn btn-primary"> 
								<i class="fa fa-filter" aria-hidden="true"></i> 
							</button>
						</div>											
						<div class="form-group">	
							<button type="button" id="quitar" class="btn btn-primary"> 
								X
							</button>
						</div>	
					
					{{ Form::close() }}
					
				</div>
			</div>	
		</div>

		<div class="card-body">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<div class="detalle">
						@include('admin.movcheques.detalle')
					</div>		                
				</div>
			</div>
		</div>		
	</div>

@endsection

@section('js')

	<script>


	$(document).ready(function() {

		
		crearDataTable('cheques', 1, 1);
		

		$('#filtro').on('click', function(){

			var token 		= $('input[name=_token]').val();

			$.ajax({
				url 	: $('.form-ajax').attr('action'),
				headers : {'X-CSRF-TOKEN': token},
				type 	: 'POST',
				dataType: 'json',
				data 	: { banco : $("#banco").val(), desde: $("#desde").val(), hasta:$("#hasta").val()},

				success: function(data){
					$('.detalle').html(data);
					crearDataTable('cheques', 1, 1);
				}
			});

			return false;
		})

		$('#quitar').on('click', function(){

			var token 		= $('input[name=_token]').val();

			$.ajax({
				url 	: $('.form-ajax').attr('action'),
				headers : {'X-CSRF-TOKEN': token},
				type 	: 'POST',
				dataType: 'json',
				data 	: { quitar : true},

				success: function(data){

					$('.detalle').html(data);
					crearDataTable('cheques', 1, 1);
					$('#banco').val('');
					$('#desde').val('');
					$('#hasta').val('');
				}
			});

			return false;
		})

	});

	</script>

@endsection
