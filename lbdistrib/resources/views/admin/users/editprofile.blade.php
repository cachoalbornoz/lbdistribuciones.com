@extends('base.base')

@section('title', 'Editar usuario '. $user->name)

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

{!! Form::open(['route' => ['users.updateprofile'], 'method' => 'POST', 'files' => 'true']) !!}

<div class="card">
	<div class="card-header">
		<div class="row">
    		<div class="col-xs-12 col-sm-12 col-lg-12">
            	<h5> Perfil {{$user->name}} </h5>				
            </div>
		</div>
	</div>
	
	<div class="card-body">   
		<div class="row">
    		<div class="col-xs-12 col-sm-12 col-lg-12">
        		<div class="form-group">
					{!! Form::text('id', $user->id, [ 'class' => 'd-none']) !!}
				</div>            

                <div class="form-group text-center">
                	@if(isset($user->image))
	            		<img src="{{ asset('images/upload/usuarios/'. $user->image) }}" class="img-thumbnail">
	            	@else
                        <img src="{{ asset('/images/frontend/user.jpg')}}" class="img-thumbnail"> 
                    @endif
                </div>                    

                <div class="form-group">
					{!! Form::label('image', 'Foto perfil') !!}
					{!! Form::file('image', null, ['class' => 'file']) !!}
				</div>               
                
            
				<div class="form-group">
					{!! Form::label('name', 'Nombre') !!}
					{!! Form::text('name', $user->name, ['class' => 'form-control', 'required', 'placeholder' => 'Nombre de usuario']) !!}
				</div>

				<div class="form-group">
					{!! Form::label('email', 'Email') !!}
					{!! Form::email('email', $user->email, ['class' => 'form-control', 'required', 'placeholder' => 'example@gmail.com']) !!}
				</div>								
			</div>
		</div>
	</div>		

	<div class="card-footer">
		<div class="row">
    		<div class="col-xs-12 col-sm-12 col-lg-12">
				{!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}	
			</div>			
		</div>
	</div>
</div>
{!! Form::close()  !!}

@endsection