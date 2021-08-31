@extends('base.base-pdf')

@section('title', 'Listado movimientos')

@section('content')

	<table width="100%">
		<tr>
			<td>CLIENTE ::   <b>{{ $contacto->nombreempresa }}</b> {{ $contacto->apellido}}, {{$contacto->nombres}}</td>  / CUIT {{ $contacto->cuit }}
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>SALDO $ <b>{{ $contacto->saldo }}</b></td>
		</tr>
		<tr>
			<td> <hr> </td>
		</tr>
	</table>
	<br>
	<table class="table table-bordered text-center" id="movcontactos">
	<thead>		
		<tr>
			<th>Fecha</th>
			<th>Concepto</th>
			<th>Nro</th>
			<th>Debe</th>
			<th>Haber</th>
			<th>Saldo</th>
		</tr>
	</thead>
	<tbody>		
		@foreach($movcontactos as $movcontacto)
		<tr>
			<td>{{ date('d-m-Y', strtotime($movcontacto->fecha)) }}</td>
			<td style='text-align: left;'>{{ $movcontacto->concepto }}</td>
			<td>{{ $movcontacto->nro }}</td>
			<td>{{ $movcontacto->debe }}</td>
			<td>{{ $movcontacto->haber }}</td>
			<td>{{ $movcontacto->saldo }}</td>
		</tr>
		@endforeach

	</tbody>		
	</table>

@endsection