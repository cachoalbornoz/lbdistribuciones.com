@extends('base.base')

@section('title', 'Cambio password')

@section('content')
	
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-lg-12">
					<h5>Cambiar contraseña</h5>
				</div>
			</div>
		</div>	
			
		<div class="card-body">
			<div class="row justify-content-center">
				<div class="col-xs-12 col-sm-6 col-lg-6">
					@if (Session::has('success'))
						<div class="alert alert-success">{!! Session::get('success') !!}</div>
					@endif
					@if (Session::has('failure'))
						<div class="alert alert-danger">{!! Session::get('failure') !!}</div>
					@endif
					<form action="{{ route('password.update') }}" method="post" role="form" class="form-horizontal">
						{{csrf_field()}}

							<div class="form-group{{ $errors->has('old') ? ' has-error' : '' }}">
								<label>Contraseña anterior</label>
								<input id="password" type="password" class="form-control" name="old">
								@if ($errors->has('old'))
									<span class="help-block">
										<strong>{{ $errors->first('old') }}</strong>
									</span>
								@endif								
							</div>

							<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
								<label>Contraseña</label>
								<input id="password" type="password" class="form-control" name="password">
								@if ($errors->has('password'))
									<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
								@endif
								
							</div>

							<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
								<label>Confirme contraseña</label>
								<input id="password-confirm" type="password" class="form-control" name="password_confirmation">
								@if ($errors->has('password_confirmation'))
									<span class="help-block">
									<strong>{{ $errors->first('password_confirmation') }}</strong>
								</span>
								@endif								
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-primary form-control">Cambiar</button>	
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
@endsection
