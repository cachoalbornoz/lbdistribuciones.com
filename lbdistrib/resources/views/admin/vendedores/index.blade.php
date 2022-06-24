@extends('base.base')

@section('title', 'Listar vendedores')

@section('breadcrumb')
    {!! Breadcrumbs::render('inicio') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    Vendedores
                </div>

                <div class="card-body">
                    <div class="detalle">

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover small text-center" id="vendedores">
                                <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Nombres y apellido</th>
                                        <th>Email</th>
                                        <th>Editar</th>
                                        <th>Ver marcas asociadas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.vendedores.edit')

@endsection

@section('js')

    <script>
        var table = $('#vendedores').DataTable({
            stateSave: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: "{{ route('vendedor.index') }}",
            columns: [{
                    data: 'id',
                    'class': 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'editar',
                    'class': 'text-center',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'asociar',
                    'class': 'text-center',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        const editVendedor = (vendedor) => {
            $("#vendedor_id").val(vendedor.id);
            $("#nombres").val(vendedor.name);
            $("#editVendedor").modal('show');
        }

        const actualizar = () => {

            const id = $("#vendedor_id").val();
            $.ajax({
                type: 'POST',
                url: '{{ route('vendedor.actualizar') }}',
                data: {
                    '_token': $('input[name=_token]').val(),
                    id,
                    'name': $('#nombres').val(),
                },
                success: function(data) {
                    $("#vendedor_id").val('');
                    $("#nombres").val('');
                    $("#editVendedor").modal('hide');
                    toastr.options = { "progressBar": true, "showDuration": "300", "timeOut": "1000" };
                    toastr.info('Vendedores', 'Actualizado ! ', {closeButton: false });
                    table.ajax.reload();
                },
                error: function(xhr) {
                    $('#errores').html('');
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#errores').append('<div class="alert alert-danger">' + value + '</div');
                    });
                    $("#editVendedor").modal('show');
                }
            });
        };
    </script>

@endsection
