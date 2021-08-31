@extends('base.base')

@section('title', 'Crear roles')

@section('breadcrumb')
    {!! Breadcrumbs::render('roles.create') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    Crear rol
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-12">

                            {{ Form::open(['route' => 'roles.store']) }}

                                @include('admin.roles.detalle')

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

	<script>

	$(document).ready(function() {

        crearDataTable('permisos', 1, 3);

        var $tbl    = $('#permisos');
        var $bodychk= $tbl.find('tbody input:checkbox');

        $bodychk.each(function() {
            if ($(this).prop("checked")) {
                $(this).closest('tr').toggleClass('bg-primary');
            }
        });

        $(function () {
            $bodychk.on('change', function () {
                $(this).closest('tr').toggleClass('bg-primary');
            });

            $tbl.find('thead input:checkbox').change(function () {
                var c = this.checked;
                $bodychk.prop('checked', c).closest("tr").toggleClass('bg-primary');
            });
        });

	});

	</script>

@endsection
