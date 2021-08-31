@extends('base.base')

@section('title', 'Actualizacion productos')

@section('breadcrumb')
	{!! Breadcrumbs::render('actualizacion.parametros') !!}
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
    
<form action="{{ route('producto.consulta') }}" method="POST" onsubmit="return verifica();"> {{ csrf_field() }}


<div class="row">
	<div class="col-md-6">
        <div class="card card-solid card-primary">
        	<div class="card-header">
                <h5>
                    Grupos
                </h5>
            </div>  	            
			<div class="card-body">
				<table class="table table-bordered">
					<tbody>
						<tr>
							<td>
								<div class="form-group">
									{!! Form::label('proveedor', 'Proveedor') !!}
									{!! Form::select('proveedor', $proveedor, null, ['id' => 'proveedor', 'class' => 'select-chosen form-control', 'placeholder' => 'Seleccione proveedor']) !!}		
								</div>	
							</td>
						</tr>
						<tr>
							<td>
								<div class="form-group">
									{!! Form::label('rubro', 'Rubro') !!}
									{!! Form::select('rubro', $rubro, null, ['id' => 'rubro', 'class' => 'select-chosen form-control', 'placeholder' => 'Seleccione rubro']) !!}		
								</div>	
							</td>							
						</tr>
						<tr>
							<td>
								<div class="form-group">
									{!! Form::label('marca', 'Marca') !!}
									{!! Form::select('marca', $marca, null, ['id' => 'marca', 'class' => 'select-chosen form-control', 'placeholder' => 'Seleccione marca']) !!}		
								</div>	
							</td>
						</tr>						
					</tbody>
				</table>				
			</div>
		</div>		
	</div>			

	<div class="col-md-6">
		<div class="card card-solid card-primary">	 
			<div class="card-header">
                <h5>
                    Indices
                </h5>
            </div>           
			<div class="card-body">	
				<table class="table table-bordered text-center">
					<thead>
						<tr>
							<td>Complete el indice con valores <b>entre 0 y 2</b></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<div class="input-group">
									<span class="input-group-addon">Bonificación</span>
									{!! Form::number('bonificacion', null, ['id' => 'bonificacion', 'class' => 'form-control', 'aria-describedby="basic-addon2"', 'min=0 max=2 step=0.01']) !!}
									<span class="input-group-addon" id="basic-addon2"><i class="fa fa-percent" aria-hidden="true"></i></span>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="input-group">
									<span class="input-group-addon">Flete</span>
									{!! Form::number('flete', null, ['id' => 'flete', 'class' => 'form-control', 'aria-describedby="basic-addon2"', 'min=0 max=2 step=0.01']) !!}
									<span class="input-group-addon" id="basic-addon2"><i class="fa fa-percent" aria-hidden="true"></i></span>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div class="input-group">
									<span class="input-group-addon">Margen</span>
									{!! Form::number('margen', null, ['id' => 'margen', 'class' => 'form-control', 'aria-describedby="basic-addon2"', 'min=0 max=2 step=0.01']) !!}
									<span class="input-group-addon" id="basic-addon2"><i class="fa fa-percent" aria-hidden="true"></i></span>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>		
	</div>
</div>
<div class="row">
	<div class="col-md-12 text-right">
		{!! Form::submit('Aplicar filtro ', ['class' => 'btn btn-primary btn-md']) !!}	
	</div>		
</div>

{!! Form::close()  !!} 

@stop

@section('js')

	<script>
		function verifica(){

			var proveedor 	= $("#proveedor").val();
			var marca 		= $("#marca").val();
			var rubro 		= $("#rubro").val();

			var bonificacion= $("#bonificacion").val();
			var flete 		= $("#flete").val();
			var margen 		= $("#margen").val();

			if(proveedor!=null | marca!=null | rubro !=null){
				if(bonificacion>0 | flete >0 | margen >0){
					return true;					
						
				}else{
					var texto = "Complete algún <b>INDICE </b> por favor";
					ymz.jq_alert({title:"Información", text:texto, ok_btn:"Ok", close_fn:null});				
					return false;
				}		

			}else{

				var texto = "Seleccione algún <b>GRUPO</b> por favor";
				ymz.jq_alert({title:"Información", text:texto, ok_btn:"Ok", close_fn:null});				
				return false;
			}
		}
		
	</script>

@stop