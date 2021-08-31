@extends('base.base')

@section('title', 'Editar producto')

@section('breadcrumb')
	{!! Breadcrumbs::render('marca.edit', $marca) !!}
@stop


@section('content')

<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12">
	        <div class="card">
	            <div class="card-header">
	                <h5>
	                    Modificar marca
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
	
	{!! Form::open(['route' => ['marca.update', $marca->id], 'method' => 'PUT', 'files' => 'true']) !!}﻿
                
	<div class="row">
        <div class="col-xs-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        Marca
                    </h5>
                </div>
                <div class="card-body">
                
                    <div class="form-group">
						{!! Form::label('nombre', 'Nombre') !!}
						{!! Form::text('nombre', $marca->nombre, ['class' => 'form-control', 'placeholder'=>'Nombre de la marca']) !!}
					</div>
                
                	<div class="form-group">
						{!! Form::label('image', 'Image') !!}
						{!! Form::file('image', null, ['class' => 'file']) !!}
					</div>
					@if(isset($marca->image))
                		<img src="{{ asset('images/upload/marcas/'. $marca->image) }}" class="img-thumbnail" width="150" height="150" >
                	@endif                	
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
