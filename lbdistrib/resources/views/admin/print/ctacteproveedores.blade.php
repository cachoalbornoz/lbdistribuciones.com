@extends('base.base-pdf')

@section('title', 'Listado movimientos')

@section('content')

	<table width="100%">
		<tr>
			<td>
				PROVEEDOR ::   <b>{{ $proveedor->nombreempresa }}</b> {{ $proveedor->apellido}}, {{$proveedor->nombres}} / CUIT {{ $proveedor->cuit }}
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td>
				SALDO $ <b>{{ $proveedor->saldo }}</b>
			</td>
		</tr>
		<tr>
			<td>
				<hr>
			</td>
		</tr>
	</table>
	<br>
	<table class="table table-bordered text-center" id="movproveedores">
	<thead>		
		<tr>
			<th>#</th>
			<th>Fecha</th>
			<th>Concepto</th>
			<th>Nro</th>
			<th>Debe</th>
			<th>Haber</th>
			<th>Saldo</th>
		</tr>
	</thead>
	<tbody>		
		@foreach($movproveedores as $movproveedor)
		<tr>
			<td>{{ $movproveedor->id }}</td>
			<td>{{ date('d-m-Y', strtotime($movproveedor->fecha)) }}</td>
			<td style='text-align: left;'>{{ $movproveedor->concepto }}</td>
			<td>{{ $movproveedor->nro }}</td>
			<td>{{ $movproveedor->debe }}</td>
			<td>{{ $movproveedor->haber }}</td>
			<td>{{ $movproveedor->saldo }}</td>
		</tr>
		@endforeach

	</tbody>		
	</table>

@endsection