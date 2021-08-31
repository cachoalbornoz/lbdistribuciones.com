@extends('base.base')



@section('title', 'Crear contactos')

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
	
	{!! Form::open(['route' => 'contacto.store', 'method'=> 'POST'])  !!}

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
						{!! Form::text('nombreempresa', null, ['class' => 'form-control', 'placeholder' => 'Razon social']) !!}	
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
						{!! Form::text('telefono', null, ['class' => 'form-control']) !!}	
					</div>

	            	<div class="form-group">
						{!! Form::label('celular', 'Celular / Movil') !!}
						{!! Form::text('celular', null, ['class' => 'form-control']) !!}	
					</div>

					<div class="form-group">
						{!! Form::label('ciudad', 'Ciudad') !!}
						{!! Form::select('ciudad', $ciudad, null, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione ciudad']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('cuit', 'Nro Cuit') !!}
						{!! Form::text('cuit', null, ['class' => 'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('tipoResponsable', 'Tipo responsable') !!}
						{!! Form::select('tipoResponsable', $tipoResponsable, null,['class' => 'select2 form-control']) !!}
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
						{!! Form::text('saldo', 0, ['class' => 'form-control text-center']) !!}
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
			{!! Form::submit('Cargar ', ['class' => 'btn btn-primary']) !!}	
		</div>		
	</div>
    
	{!! Form::close()  !!}  

@endsection
