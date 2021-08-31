@extends('base.base')

@section('title', 'Editar usuario '. $user->name)

@section('breadcrumb')
    {!! Breadcrumbs::render('users.edit', $user) !!}
@stop

@section('content')

<div class="row">
	<div class="col-xs-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>
                    Editar usuario
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

<div class="row">
	<div class="col-xs-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5>
                    Datos del usuario
                </h5>
            </div>

			<div class="card-body">

				{!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PUT', 'files' => 'true']) !!}﻿

				<div class="form-group">
					{!! Form::label('name', 'Nombre') !!}
					{!! Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => 'Nombre de usuario']) !!}
				</div>

				<div class="form-group">
					{!! Form::label('email', 'Email') !!}
					{!! Form::email('email', null, ['class' => 'form-control', 'required', 'placeholder' => 'example@gmail.com']) !!}
				</div>

				<div class="form-group">
					{!! Form::label('image', 'Foto') !!}
					{!! Form::file('image', null, ['class' => 'file']) !!}
				</div>
				@if(isset($user->foto))
            		<img src="{{ asset('images/upload/usuarios/'. $user->foto) }}" class="img-thumbnail" width="150" height="150" >
            	@endif

				<div class="form-group">
					{!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
				</div>

                <hr />

                <h5>Lista de roles disponibles</h5>

                <div class="form-group">
                    <ul class="list-unstyled">
                        @foreach ($roles as $role)
                            <li>
                                <label class="checkbox-inline">
                                    {{ Form::checkbox('roles[]', $role->id, null) }}
                                    {{ $role->name }}

                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

				{!! Form::close()  !!}

			</div>
		</div>
	</div>
</div>

@endsection
