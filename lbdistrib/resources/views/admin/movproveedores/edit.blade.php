@extends('base.base')



@section('title', 'Editar contacto')

@section('content')

	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12">
	        <div class="card">
	            <div class="card-header">
	                <h5>
	                    Contactos
	                </h5>
	            </div>
	        </div>
	    </div>
	</div>    


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
	
	{!! Form::open(['route' => ['contacto.update', $contacto->id], 'method' => 'PUT']) !!}﻿

	<div class="row">
		<div class="col-xs-12 col-sm-4 col-lg-4">
	        <div class="card">
	            <div class="card-header">
	                <h5>
	                    Datos del cliente 
	                </h5>
	            </div>
	            
				<div class="card-body">
					<div class="form-group">
						{!! Form::label('nombreempresa', 'Razón social') !!}
						{!! Form::text('nombreempresa', $contacto->nombreempresa, ['class' => 'form-control', 'placeholder' => 'Razon social']) !!}	
					</div>					

					<div class="form-group">
						{!! Form::label('apellido', 'Apellido') !!}
						{!! Form::text('apellido', $contacto->apellido, ['class' => 'form-control', 'placeholder' => 'Apellido']) !!}	
					</div>

					<div class="form-group">
						{!! Form::label('nombres', 'Nombres') !!}
						{!! Form::text('nombres', $contacto->nombres, ['class' => 'form-control', 'placeholder' => 'Nombres']) !!}	
					</div>

					<div class="form-group">
						{!! Form::label('domicilio', 'Domicilio Nro - (Dpto / Manzana / Barrio / Sector)') !!}
						{!! Form::text('domicilio', $contacto->domicilio, ['class' => 'form-control']) !!}
					</div>	
					<div class="form-group">
						{!! Form::label('email', 'Email') !!}
						{!! Form::email('email', $contacto->email, ['class' => 'form-control', 'placeholder' => 'Correo electronico']) !!}
					</div>	
						
				</div>
			</div>	
		</div>
		
	    <div class="col-xs-12 col-sm-4 col-lg-4">
	        <div class="box  box-primary">
	            <div class="card-header">
	                <h5>
	                    Otros datos
	                </h5>
	            </div>
	            <div class="card-body">
	            	<div class="form-group">
						{!! Form::label('telefono', 'Telefono') !!}
						{!! Form::text('telefono', $contacto->telefono, ['class' => 'form-control']) !!}	
					</div>

	            	<div class="form-group">
						{!! Form::label('celular', 'Celular / Movil') !!}
						{!! Form::text('celular', $contacto->celular, ['class' => 'form-control']) !!}	
					</div>

					<div class="form-group">
						{!! Form::label('ciudad', 'Ciudad') !!}
						{!! Form::select('ciudad', $ciudad, $contacto->ciudad, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione ciudad']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('cuit', 'Nro Cuit') !!}
						{!! Form::text('cuit', $contacto->cuit, ['class' => 'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('tipoResponsable', 'Tipo responsable') !!}
						{!! Form::select('tipoResponsable', $tipoResponsable, $contacto->tipoResponsable, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione responsabilidad']) !!}
					</div>	            		
	            </div>
	        </div>    	
	    </div>
	    <div class="col-xs-12 col-sm-4 col-lg-4">
	        <div class="box box-solid box-success">
	            <div class="card-header">
	                <h5>
	                    Saldo Actual
	                </h5>
	            </div>
	            <div class="card-body">

	            	<div class="form-group">
						<div class="form-group">
						{!! Form::label('saldo', 'Saldo') !!}
						{!! Form::text('saldo', $contacto->saldo, ['class' => 'form-control text-center']) !!}
					</div>
					</div>

	            	<div class="form-group">
						
					</div>

					<div class="form-group">
						
					</div>	            		
	            </div>
	        </div>    	
	    </div>		       
    </div>

	<div class="row">
		<div class="col-md-3">
			{!! Form::submit('Actualizar ', ['class' => 'btn btn-primary']) !!}	
		</div>		
	</div>
    
	{!! Form::close()  !!}  

@endsection
