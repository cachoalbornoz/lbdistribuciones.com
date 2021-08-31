@extends('base.base')

@section('title', 'Listado de Presupuestos')

@section('breadcrumb')
{!! Breadcrumbs::render('presupuesto') !!}
@stop

@section('content')


<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-lg-6">
				<h5>
					Presupuestos facturados
				</h5>
			</div>	
			<div class="col-xs-6 text-right">
				<a href="{{ route('presupuesto.index') }}" class="btn btn-link">
					Presupuesto								
				</a>
			</div>
		</div>
	</div>
	
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-hover"  style="font-size: smaller">
			<thead class="bg-secondary text-white">
				<tr>
					<th width="15px">#</th>
					<th class="text-center">Fecha facturación</th>
					<th>Razón social</th>
					<th class="text-center">Productos presupuestados</th>
					<th>Observaciones</th>
					<th>Vendedor</th>
					<th width="15px"> </th>
				</tr>
			</thead>
			<tbody>
			@foreach($presupuestos as $presupuesto)

			<tr id="fila{{ $presupuesto->id }}">
				<td>
					{{ $loop->iteration }}
				</td>
				<td class="text-center">
					{{ date('d/m/Y H:i', strtotime($presupuesto->created_at)) }}
				</td>
				<td>
					<a href="{{ route('detallepresupuesto.show', $presupuesto->id) }}">
						@if (isset($presupuesto->Contacto->nombreempresa))
							{{ $presupuesto->Contacto->nombreempresa }}
						@else
							Info no disponible
						@endif
					</a>
				</td>
				<td class="text-center">{{ $presupuesto->productos->count() }}</td>
				<td>{{ $presupuesto->observaciones }}</td>
				<td>{{ $presupuesto->Vendedor->nombreCompleto() }}</td>
				<td>
					@can('presupuesto.destroy')
					<button type="button" class="btn btn-default btn-link" id="eliminar" name="eliminar" value="{{ $presupuesto->id }}" onclick="return eliminarRegistro(this.value, '{{ route('presupuesto.destroy') }}')">
						<i class="fa fa-trash-o text-danger" aria-hidden="true"></i>
					</button>
					@endcan
				</td>
			</tr>

			@endforeach

			</tbody>
		</table>
		</div>
		<div class="box-footer clearfix">
			{{ $presupuestos->appends(Request::all())->links() }}
		</div>
	</div>
</div>

@endsection

@section('js')

<script>


</script>

@stop
