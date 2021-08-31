@extends('base.base')

@section('title', 'Crear marca')

@section('breadcrumb')
	{!! Breadcrumbs::render('marca.create') !!}
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
	                    Crear marca
	                </h5>
	            </div>
	        </div>
	    </div>
	
	
	{!! Form::open(['route' => 'marca.store', 'method'=> 'POST', 'files' => 'true'])  !!}

	<div class="card-body">            
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">                
			
				<div class="form-group">
					{!! Form::label('nombre', 'Nombre') !!}
					{!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder'=>'Nombre de la marca', 'required'=>'true']) !!}
				</div>
			
				<div class="form-group">
					{!! Form::label('image', 'Image') !!}
					{!! Form::file('image', null, ['class' => 'file']) !!}
				</div>
				
			</div>
		</div>

		<div class="row">
			<div class="col-md-3">
				{!! Form::submit('Cargar ', ['class' => 'btn btn-primary']) !!}	
			</div>		
		</div>
	</div>	

</div>

	
    
	{!! Form::close()  !!}  

@endsection
