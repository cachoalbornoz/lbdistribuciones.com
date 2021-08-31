@extends('base.base')

@section('title', 'Crear contactos')

@section('breadcrumb')
	{!! Breadcrumbs::render('contacto.create') !!}
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

	<div class="card">

	    <div class="card-header">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12">
	                <h5>
	                    Contactos
	                </h5>
	            </div>
	        </div>
	    </div>	

		<div class="card-body">

			<div class="row mb-3">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<h5>
						Datos del cliente
					</h5>
				</div>
			</div>

			{!! Form::open(['route' => 'contacto.store', 'method'=> 'POST'])  !!}

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-lg-4">				

					<div class="form-group">
						{!! Form::label('nombreempresa', 'Razón social') !!}
						{!! Form::text('nombreempresa', null, ['class' => 'form-control', 'placeholder' => 'Razon social', 'autofocus' => 'true']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('apellido', 'Apellido') !!}
						{!! Form::text('apellido', null, ['class' => 'form-control', 'placeholder' => 'Apellido']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('nombres', 'Nombres') !!}
						{!! Form::text('nombres', null, ['class' => 'form-control', 'placeholder' => 'Nombres']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('domicilio', 'Domicilio Nro - (Dpto / Manzana / Barrio / Sector)') !!}
						{!! Form::text('domicilio', null, ['class' => 'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('email', 'Email') !!}
						{!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Correo electronico']) !!}
					</div>

				</div>
			
	    		<div class="col-xs-12 col-sm-12 col-lg-4">	                
	            
	            	<div class="form-group">
						{!! Form::label('telefono', 'Telefono') !!}
						{!! Form::text('telefono', null, ['class' => 'form-control']) !!}
					</div>

	            	<div class="form-group">
						{!! Form::label('celular', 'Celular / Movil') !!}
						{!! Form::text('celular', null, ['class' => 'form-control']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('ciudad', 'Ciudad') !!}
						{!! Form::select('ciudad', $ciudad, null, ['class' => 'form-control', 'placeholder' => 'Seleccione ciudad']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('cuit', 'Nro Cuit') !!}
						{!! Form::text('cuit', null, ['class' => 'form-control', 'maxlength' => '11']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('tiporesponsable', 'Tipo responsable') !!}
						{!! Form::select('tiporesponsable', $tipoResponsable, null,['class' => 'form-control']) !!}
					</div>
	            </div>
	        
	            <div class="col-xs-12 col-sm-12 col-lg-4">

					<div class="form-group">
						{!! Form::label('saldo', 'Saldo') !!}
						{!! Form::text('saldo', 0, ['class' => 'form-control text-center']) !!}
					</div>					
					
					@can('contacto.destroy')
					<div class="form-group">
						
		                {!! Form::label('vendedor', 'Vendedor asignado') !!}

						<hr />

	                    <ul class="list-unstyled">
	                        @foreach ($vendedores as $vendedor)
	                            <li>
	                                <label>{{ Form::radio('vendedor', $vendedor->id) }} {{ $vendedor->nombrecompleto() }}</label>
	                            </li>
	                        @endforeach
	                    </ul>
					</div>
					@endcan

					<div class="form-group">
						&nbsp;
					</div>

	            </div>
	        </div>

			{!! Form::submit('Cargar ', ['class' => 'btn btn-primary']) !!}

			{!! Form::close()  !!}

		</div>
	</div>

	

@endsection
