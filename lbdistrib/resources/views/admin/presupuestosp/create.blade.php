@extends('base.base')

@section('title', 'Carga presupuestos')

@section('breadcrumb')
	{!! Breadcrumbs::render('presupuestop.create') !!}
@stop

@section('content')

	<div class="row mb-2">
		<div class="col-xs-12 col-md-12 col-lg-12">
	        <div class="card">
	            <div class="card-header">
	                <h5>Presupuesto</h5>
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

	{!! Form::open(array('route' => 'presupuestop.store', 'method'=> 'POST', 'class'=>'form-horizontal', 'role' => 'form'))  !!}

	{!! Form::select('tipocomprobante', $tipocomprobante, $tipocomprobante, ['class' => 'd-none']) !!}

	<div class="card border border-primary">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-lg-12">
				<table class="table table-borderless" style="font-size: smaller">
					<tr>
                        <td style="width: 15%">
                            <span class="input-group-text">
								&nbsp; Proveedor
							</span>
                        </td>
						<td>
							{!! Form::select('proveedor', $proveedor, null, [ 'id'=>'proveedor', 'class' => 'form-control', 'placeholder' => 'Seleccione proveedor']) !!}
						</td>
						<td style="width: 15%"> 
							<span class="input-group-text">
								<i class="fa fa-calendar text-primary"></i> &nbsp; Fecha
							</span>
						</td>
						<td style="width: 15%">
							{!! Form::date('fecha', \Carbon\Carbon::now(), ['class' => 'form-control', 'placeholder' => 'Fecha comprobante']) !!}
							</td>
					</tr>
					<tr>
						<td> 
							<span class="input-group-text">
								Forma de pago
							</span>	
						</td>
						<td>
							{!! Form::select('formapago', $formapago, null, ['class' => 'form-control']) !!}
                        </td>
                        <td></td>
                        <td></td>
					</tr>
					<tr>
						<td>
                            <span class="input-group-text">
								&nbsp; Observaciones
							</span>
                        </td>
						<td>
                            {!! Form::text('observaciones', null, ['class' => 'form-control']) !!}							
                            <small>
                                Máx 150 caracteres
                            </small>
						</td>
						<td></td>
						<td>
                            {!! Form::submit('Cargar ', ['class' => 'btn btn-primary btn-block']) !!}
                        </td>
					</tr>
				</table>	
			</div>
		</div>

	</div>	

	{!! Form::close()  !!}


@stop

@section('js')

<script>

	$(document).ready(function(){

	})


</script>

@stop