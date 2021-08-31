@extends('base.base')

@section('title', 'Editar cheque')

@section('breadcrumb')
	{!! Breadcrumbs::render('cheque.edit', $cheque) !!}
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
						Detalle del cheque
	                </h5>
	            </div>
	        </div>
	    </div>

		{!! Form::model($cheque, ['route' => ['cheque.update', $cheque->id], 'method' => 'POST']) !!}
	
		<div class="card-body">
			<div class="row">
				<div class="col-xs-12 col-md-6 col-lg-6">
					
					<div class="form-group">
						{!! Form::label('nrocheque', 'Nro cheque') !!}
						{!! Form::text('nrocheque', null, ['class' => 'form-control', 'placeholder' => 'Nro de cheque']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('contacto', 'Recibido de') !!}
						{!! Form::select('contacto', $contacto, $cheque->contacto, ['class' => 'select2 form-control']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('fechacobro', 'Fecha que se recibió') !!}
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-calendar text-primary"></i>
								</span>								
							</div>
							{!! Form::date('fechacobro', null, ['class' => 'form-control', 'placeholder' => 'Fecha cobro']) !!}
						</div>	
					</div>

					<div class="form-group">
						{!! Form::label('observacion', 'Observaciones') !!}
						{!! Form::text('observacion', null, ['class' => 'form-control', 'placeholder' => 'Observaciones del cheque (máx 200 caracteres)', 'maxlength' => '200' ]) !!}
					</div>

				</div>

				<div class="col-xs-12 col-md-6 col-lg-6">
					
					<div class="form-group">
						{!! Form::label('importe', 'Importe') !!}
						{!! Form::number('importe', null, ['class' => 'form-control', 'step'=>'any']) !!}
					</div>

					<div class="form-group">
						{!! Form::label('banco', 'Banco') !!}
						{!! Form::select('banco', $banco, null, ['class' => 'select2 form-control', 'placeholder' => 'Seleccione banco']) !!}
					</div>

					<div class="form-group">
						<label>Fecha que se entregó </label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<i class="fa fa-calendar text-primary"></i>
								</span>								
							</div>
							{!! Form::date('fechapago', null, ['class' => 'form-control', 'placeholder' => 'Fecha pago']) !!}
						</div>	
					</div>

					<div class="form-group">
						{!! Form::label('observacionpago', 'Observaciones de pago') !!}
						{!! Form::text('observacionpago', null, ['class' => 'form-control', 'placeholder' => 'A quién entrega el cheque, etc...(máx 200 caracteres)', 'maxlength' => '200' ]) !!}
					</div>

					<div class="form-group">
						<label class="checkbox">
							<input id="cobrado" name="cobrado" type="checkbox" @if ($cheque->cobrado == 1) checked	@endif value="{{$cheque->cobrado}}"> Cobrado
						</label>
					</div>
	            </div>
	        </div>

			<div class="row">
				<div class="col-xs-12 col-sm-12 col-lg-12 text-right">
					{!! Form::submit('Actualizar ', ['class' => 'btn btn-primary']) !!}
				</div>
			</div>
			
	    </div>
    </div>

	{!! Form::close()  !!}

@stop

@section('js')

	<script>

	$("#cobrado").change(function(){
		if($(this).prop("checked") == true){
			$(this).val(1);
		}else{
			$(this).val(0);
		}
	});


	</script>

@stop
