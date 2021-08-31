@extends('base.base')

@section('title', 'Cargar cheque')

@section('breadcrumb')
	{!! Breadcrumbs::render('cheque.create') !!}
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
	                    Cheques
	                </h5>
	            </div>
	        </div>
	    </div>

		{!! Form::open(['route' => 'cheque.store', 'method'=> 'POST'])  !!}
	
	    <div class="card-body">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-lg-6">

					<div class="form-group">
						{!! Form::label('nrocheque', 'Nro cheque') !!}
						{!! Form::text('nrocheque', null, ['class' => 'form-control', 'placeholder' => 'Nro de cheque', 'autofocus' => 'true']) !!}
					</div>
					
					<div class="form-group">
						{!! Form::label('contacto', 'Recibido de') !!}
						{!! Form::select('contacto', $contacto, null, ['class' => 'select2 form-control']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('fechacobro', 'Fecha que se recibió') !!}
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-calendar text-primary"></i>
								</span>								
							</div>
							{!! Form::date('fechacobro', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'Fecha cobro']) !!}
						</div>
					</div>

					<div class="form-group">
						{!! Form::label('observacion', 'Observaciones') !!}
						{!! Form::text('observacion', null, ['class' => 'form-control', 'placeholder' => 'Observaciones del cheque (máx 200 caracteres)', 'maxlength' => '200' ]) !!}
					</div>

				</div>
			
	    		<div class="col-xs-12 col-sm-6 col-lg-6">

					<div class="form-group">
						{!! Form::label('importe', 'Importe') !!}
						{!! Form::number('importe', null, ['class' => 'form-control', 'step'=>'any']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('banco', 'Banco') !!}
						{!! Form::select('banco', $banco, null, ['class' => 'select2 form-control']) !!}
					</div>

					<div class="form-group">
						<label>Fecha que se entregó </label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-calendar text-primary"></i>
								</span>								
							</div>							
							{!! Form::date('fechapago', null, ['class' => 'form-control']) !!}
						</div>
					</div>

					<div class="form-group">
						{!! Form::label('observacionpago', 'Observaciones de pago') !!}
						{!! Form::text('observacionpago', null, ['class' => 'form-control', 'placeholder' => 'A quién entrega el cheque, etc...(máx 200 caracteres)', 'maxlength' => '200' ]) !!}
					</div>

					<div class="form-group">
						<label>
							<input id="cobrado" name="cobrado" type="checkbox" value=""	> Cobrado							
						</label>
					</div>

	            </div>
	        </div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-lg-12 text-right">
					{!! Form::submit('Guardar ', ['class' => 'btn btn-primary']) !!}
				</div>
			</div>

	    </div>
    </div>

	{!! Form::close()  !!}

@stop

@section('js')

	<script>


	</script>

@stop
