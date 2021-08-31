@extends('base.base')

@section('title', 'Listar usuarios')

@section('breadcrumb')
    {!! Breadcrumbs::render('users') !!}
@endsection

@section('content')

<div class="row">
	<div class="col-xs-12 col-sm-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				Usuarios DataTable
            </div>

			<div class="card-body">
                <table id="users-table" class="table table-hover table-primary w-100">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Producto</th>
                            <th>Precio lista</th>
                            <th>Precio venta</th>
                            <th>Stock aviso</th>
                            <th>Rubro</th>
                            <th>Editar</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
		</div>
	</div>
</div>

@endsection

@section('js')

	<script>

	$(function() {

        var table = $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            language: {
                "url": "{{ url('/js/spanish.json') }}",
            },
            ajax: {
                url: "{{ route('users.data') }}",
                dataSrc: "data",
                type: "GET"
            },
            columns: [
                { "data": "id"},
                { "data": "nombre"},
                { "data": "preciolista"},
                { "data": "precioventa"},
                { "data": "stockaviso" },
                { "data": "rubro" },
                { "data": "action", orderable: false, searchable: false},
            ],
        });

    });

    </script>

@endsection
