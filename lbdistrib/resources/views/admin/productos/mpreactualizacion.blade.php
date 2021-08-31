@extends('base.base')

@section('title', 'Actualizacion productos')

@section('breadcrumb')
	{!! Breadcrumbs::render('actualizacion.consulta') !!}
@stop


@section('content')

<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				Actualizacion de Precios
			</div>
		</div>
	</div>
</div>	            
    


<form action="{{ route('producto.actualiza') }}" method="POST"> {{ csrf_field() }}


{!! Form::number('proveedor', $proveedor	, ['id' => 'proveedor', 'class' => 'd-none']) !!}
{!! Form::number('rubro'	, $rubro 		, ['id' => 'rubro', 'class' => 'd-none']) !!}		
{!! Form::number('marca'	, $marca 		, ['id' => 'marca', 'class' => 'd-none']) !!}		
{!! Form::number('bonificacion', $bonificacion, ['id' => 'bonificacion', 'class' => 'd-none']) !!}									
{!! Form::number('flete'	, $flete 		, ['id' => 'flete', 'class' => 'd-none']) !!}
{!! Form::number('margen'	, $margen 		, ['id' => 'margen', 'class' => 'd-none']) !!}

<div class="row">
	<div class="col-xs-12 col-md-12 col-lg-12">
        <div class="card card-solid card-primary">
        	<div class="card-header">
                <h5>Resultado del filtro</h5>
            </div>  	            
			<div class="card-body">
				<table class="table table-bordered">
					<caption>

						@if (isset($proveedor->id))
							# {!! $proveedor->id !!} <b> {!! $proveedor->nombreempresa !!} </b> - {!! $proveedor->apellido !!}, {!! $proveedor->nombres !!} 
						@else
							Ninguno
						@endif

					</caption>
					<thead>
						<tr>
							<td class="text-left">Producto</td>
							<th>Rubro</th>
							<th>Marca</th>
							<td>P.Lista</td>
							<td>Bonif.</td>
							<td>Flete</td>
							<td>Margen</td>
							<td class="bg-warning">
								@if ($bonificacion>0)
									Bonif nueva
								@else
									@if ($flete>0)
										Flete nuevo
									@else
										Margen nuevo	
									@endif			
								@endif
							</td>

						</tr>
					</thead>
					<tbody>
						@foreach ($producto as $produ)
							<tr>
								<td class="text-left">{!! $produ->nombre !!}</td>	
								<td>{!! $produ->nombrerubro !!}</td>	
								<td>{!! $produ->nombremarca !!}</td>
								<td>{!! $produ->preciolista !!}</td>
								<td>{!! $produ->bonificacion !!}</td>
								<td>{!! $produ->flete !!}</td>	
								<td>{!! $produ->margen !!}</td>
								<td>
									<b>
									@if ($bonificacion>0)
										{!! $bonificacion !!}
									@else
										@if ($flete>0)
											{!! $flete !!}
										@else
											{!! $margen !!}
										@endif			
									@endif
									</b>
								</td>
							</tr>														
						@endforeach
					</tbody>
				</table>
				<br>
				<small>
                	(*) Estos registros son una muestra y sirven para asegurarse que la actualización concuerde que lo solicitado.
            	</small>									
			</div>
		</div>		
	</div>			
</div>
<div class="row">
	<div class="col-md-12 text-right">
		{!! Form::submit('Confirma ', ['class' => 'btn btn-primary']) !!}	
	</div>		
</div>	

{!! Form::close()  !!} 

@stop
