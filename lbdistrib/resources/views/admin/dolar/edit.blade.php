@extends('base.base')

@section('title', 'Actualizar dolar')

@section('breadcrumb')
	{!! Breadcrumbs::render('actualizacion.parametro') !!}
@stop

@section('content')

	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12">
			@if (count($errors) > 0)
				<div class="alert alert-danger" role="alert">
					<ul>
						@foreach ($errors->all() as $error)
							<li>
								{{ $error }}
							</li>
						@endforeach
					</ul>
				</div>
			@endif
		</div>
	</div>

	{!! Form::open(['route' => ['dolar.update', $dolar->id], 'method' => 'PUT']) !!}

	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<h5>
						Cotización del Dolar - U$s
					</h5>
				</div>
			</div>
		</div>		
		
		<div class="card-body">  		

			<div class="row">
				<div class="col-xs-12 col-sm-6 col-lg-6">		
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-prepend" >
								<span class=" input-group-text">
									U$s
								</span>	
							</div>
							{!! Form::number('valoractual', $dolar->valoractual, ['class' => 'form-control', 'step'=>'any']) !!}
						</div>							
					</div>
				</div>
			
				<div class="col-xs-12 col-sm-6 col-lg-6">					
					<div class="form-group text-center">
						<p>Atención al actualizar el <b><i> valor del dolar (U$s) </i></b> también actualizará todos los productos relacionados</p>
					</div>
				</div>	
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-lg-12">	
					<div class="form-group">
						{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}	
					</div>						
				</div>
			</div>

		</div>
	</div>

	{!! Form::close()  !!}

@stop

@section('js')


@stop
